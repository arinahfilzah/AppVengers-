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

            LoginHistory::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'logged_in_at' => now (),
                //'device' => $request->header('User-Agent'),
            ]);

            // Save last login
            Auth::user()->update([
                'last_login' => now(),
            ]);
    
            $request->session()->regenerate();
            return redirect('/dashboard');
        }
    
        return back()->withErrors(['loginError' => 'Invalid email or password']);
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'confirmed',   // must match new_password_confirmation
            ],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

    // Store active tab in session
    return redirect()->route('account')
                     ->with('password_success', 'Password updated successfully!')
                     ->with('active_tab', 'settings');
    }

    // Show Dashboard
    public function showDashboard()
    {
        $user = Auth::user();

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
    
    //Update profile 
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('account')
            ->with('success', 'Profile updated successfully!')
            ->with('active_tab', 'profile');
    }

    //  Return JSON data for login history chart
    public function loginHistoryData()
    {
        $user = Auth::user();

        // Get login records for last 7 days
        $last7Days = now()->subDays(6)->startOfDay();
        $loginRecords = $user->loginHistories()
                            ->where('logged_in_at', '>=', $last7Days)
                            ->get();

        // Group by date
        $data = [];
        foreach ($loginRecords as $record) {
            $date = $record->logged_in_at->format('Y-m-d');
            if (!isset($data[$date])) {
            $data[$date] = 0;
            }
            $data[$date]++;
        }

        return response()->json($data);
    }
}
