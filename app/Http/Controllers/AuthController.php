<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
USE App\Models\LoginHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    public function showLogin() 
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // UC01 - Register
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',      // at least one lowercase
                'regex:/[A-Z]/',      // at least one uppercase
                'regex:/[0-9]/',      // at least one number
                'confirmed',           // must match password_confirmation
            ],
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
    
        return redirect('/login')->with('success', 'Registration successful. Please log in.');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to home with message
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
    

    // UC02 - Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {

            $user = Auth::user();
            $userAgent = $request->header('User-Agent');

            // --- Convert User-Agent to friendly device name ---
            $deviceName = $this->parseUserAgent($userAgent);

            // --- Add to Trusted Devices if not already there ---
            $trustedDevices = $user->trusted_devices ?? [];
            if (!in_array($deviceName, $trustedDevices)) {
                // Optional: Limit to last 5 devices
                if (count($trustedDevices) >= 5) {
                    array_shift($trustedDevices); // remove oldest device
                }
                $trustedDevices[] = $deviceName;
                $user->trusted_devices = $trustedDevices;
                $user->save();
            }

            // --- Save Login History ---
            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $deviceName,  // save friendly name
                'logged_in_at' => now(),
            ]);

            // --- Save last login ---
            $user->update([
                'last_login' => now(),
            ]);

            $request->session()->regenerate();
            return redirect('/dashboard');
        }   

        return back()->withErrors(['loginError' => 'Invalid email or password']);
    }

    /**
    * Parse User-Agent to get friendly device/browser name
    */
    protected function parseUserAgent($userAgent)
    {
        // Basic parsing for popular browsers/devices
        if (preg_match('/iphone/i', $userAgent)) return 'iPhone';
        if (preg_match('/ipad/i', $userAgent)) return 'iPad';
        if (preg_match('/android/i', $userAgent)) return 'Android Device';
        if (preg_match('/windows nt/i', $userAgent)) return 'Windows PC';
        if (preg_match('/macintosh/i', $userAgent)) return 'Mac';
        if (preg_match('/linux/i', $userAgent)) return 'Linux PC';

        // Fallback to first 50 chars of full User-Agent
        return substr($userAgent, 0, 50);
    }
   
    // UC02 - Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // UC03 - Password Reset Request
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Reset link sent!'])
            : back()->withErrors(['email' => 'Email not found']);
    }

    // UC03 - Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'confirmed',   // must match new_password_confirmation
            ],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])
                     ->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect('/login')->with('status', 'Password reset successful!')
            : back()->withErrors(['email' => 'Invalid token or expired link']);
    }

    // Show Reset Password Form
    public function showResetPasswordForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
        return redirect('/forgot-password')->withErrors(['email' => 'Invalid password reset link.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    // Show Dashboard
public function showDashboard()
{
    $user = Auth::user();

    // Check if the user is an admin
    if ($user->role === 'admin') {
        // Redirect to the admin dashboard
        return redirect()->route('admin.dashboard');
    }

    // Otherwise, return the normal user's dashboard
    return view('dashboard', [
        'user' => $user,
        'lastLogin' => $user->last_login ?? 'N/A',
    ]);
}
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->route('account')
                      ->withErrors($validator)
                      ->withInput()
                      ->with('active_tab', 'settings')
        );
    }  

    //Show User Profile (with login history) 
    public function showUserProfile()
    {
        $user = Auth::user();

        // Get login history
        $loginHistory = LoginHistory::where('user_id', $user->id)
                        ->orderBy('logged_in_at', 'desc')
                        ->get();

        return view('userProfile', compact('user', 'loginHistory'));
    }
    
    // Update Profile
    public function updateProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account')
                            ->withErrors($validator, 'profile')
                            ->withInput()
                            ->with('active_tab', 'profile');
        }

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_pictures'), $filename);
            $user->profile_picture = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();

        return redirect()->route('account')
                        ->with('profile_success', 'Profile updated successfully!')
                        ->with('active_tab', 'profile');
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'new_password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'confirmed',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->route('account')
                            ->withErrors($validator, 'password')
                            ->withInput()
                            ->with('active_tab', 'settings');
        }

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('account')
                        ->with('password_success', 'Password updated successfully!')
                        ->with('active_tab', 'settings');
    }

    // Update Security Preferences
    public function updateSecurityPreferences(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'session_timeout' => 'required|integer|min:5|max:120',
            'recovery_email' => 'nullable|email',
            'recovery_phone' => 'nullable|regex:/^[0-9]{10,12}$/',
            'security_notifications' => 'sometimes|in:on,1,true,false,0', // FIXED
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('account')
                            ->withErrors($validator, 'security')
                            ->with('active_tab', 'settings');
        }
    
        $user = Auth::user();
        // Fetch current trusted devices
        $trustedDevices = $user->trusted_devices ?? [];

        // Remove device
        if ($request->has('remove_device')) {
            $index = $request->remove_device;
            if (isset($trustedDevices[$index])) {
                unset($trustedDevices[$index]);
                $trustedDevices = array_values($trustedDevices); // reindex array
                $user->trusted_devices = $trustedDevices; // save as array, casting handles JSON
                $user->save();

            return redirect()->route('account')
                            ->with('security_success', 'Trusted device removed.')
                            ->with('active_tab', 'settings');
        }
    }

        // Update preferences
        $user->update([
            'session_timeout' => $request->session_timeout,
            'recovery_email' => $request->recovery_email,
            'recovery_phone' => $request->recovery_phone,
            'security_notifications' => $request->has('security_notifications'),
            'trusted_devices' =>$trustedDevices,
        ]);
    
        return redirect()->route('account')
                         ->with('success', 'Security preferences updated!')
                         ->with('active_tab', 'settings');
    }    

    //  Return JSON data for login history chart
    public function loginHistoryData()
    {
        $user = Auth::user();

        // Get login records for last 7 days
        $loginRecords = $user->loginHistories()->get();

        // Group by date
        $data = [];
        foreach ($loginRecords as $record) {
            $date = \Carbon\Carbon::parse($record->logged_in_at)->format('Y-m-d');
            if (!isset($data[$date])) {
            $data[$date] = 0;
            }
            $data[$date]++;
        }

        return response()->json($data);
    }
}
