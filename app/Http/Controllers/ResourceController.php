<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file1' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',
            'category' => 'required',
            'year' => 'required',
            'subject' => 'required',
        ], [
            'title.required' => 'Please enter a title for your resource.',
            'file1.required' => 'Please select a file to upload.',
            'file1.mimes'    => 'Only jpg, png, pdf, or docx files are allowed.',
            'file1.max'      => 'File size cannot exceed 5MB.',
        ]);

        $fileName = time() . '_' . $request->file1->getClientOriginalName();
        $request->file1->storeAs('uploads', $fileName, 'public');

        Resource::create([
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'year'        => $request->year,
            'subject'     => $request->subject,
            'file_path'   => $fileName,
            'upload_date' => now(),
            'uploader_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Resource successfully added!');
    }

    public function manageResource()
    {
        $resources = Resource::where('uploader_id', auth()->id())->get();
        return view('resource.manageResource', compact('resources'));
    }

    public function edit($id)
    {
        $resource = Resource::findOrFail($id);
        return view('resource.editResource', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'file1' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',
            'category' => 'required',
            'year' => 'required',
            'subject' => 'required',
        ]);

        if ($request->hasFile('file1')) {
            $fileName = time() . '_' . $request->file1->getClientOriginalName();
            $request->file1->storeAs('uploads', $fileName, 'public');
            $resource->file_path = $fileName;
        }

        $resource->title = $request->title;
        $resource->description = $request->description;
        $resource->category = $request->category;
        $resource->year = $request->year;
        $resource->subject = $request->subject;
        $resource->save();

        return redirect()->route('manageResource')->with('success', 'Resource updated successfully!');
    }

    public function showUploadForm()
    {
        return view('resource.uploadResource');
    }

    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);

        // Delete file from storage
        if ($resource->file_path && Storage::disk('public')->exists('uploads/' . $resource->file_path)) {
            Storage::disk('public')->delete('uploads/' . $resource->file_path);
        }

        // Delete QR code
        if ($resource->qr_code_path && Storage::disk('public')->exists($resource->qr_code_path)) {
            Storage::disk('public')->delete($resource->qr_code_path);
        }

        $resource->delete();

        return redirect()->route('manageResource')->with('success', 'Resource deleted successfully!');
    }

    // Generate QR Code for existing resource
public function generateQrCode($id)
{ 
    try {
        $resource = Resource::findOrFail($id);

        if (!$resource->access_token) {
            $resource->access_token = Str::random(32);
            $resource->save();
        }

        // QR URL
        $url = route('resource.view', ['token' => $resource->access_token]);

        // Create QR
        $qrPng = QrCode::format('png')
                        ->size(400)
                        ->margin(2)
                        ->generate($url);
        dd($qrPng);

        // Make directory if not exists
        if (!Storage::disk('public')->exists('qrcodes')) {
            Storage::disk('public')->makeDirectory('qrcodes');
        }

        // File name + path
        $fileName = 'qr_' . $resource->id . '_' . time() . '.png';
        $path = 'qrcodes/' . $fileName;

        if (!$qrPng) {dd("QR NOT GENERATED");
}


        // ✅ SAVE FILE CORRECTLY
        Storage::disk('public')->put($path, $qrPng);
        dd($result, $path);

        // Save path to DB
        $resource->qr_code_path = $path;
        $resource->save();

        return redirect()
            ->route('manageResource')
            ->with('success', 'QR code generated successfully.');

    } catch (\Exception $e) {
        return redirect()
            ->route('manageResource')
            ->with('error', 'QR code generation failed. Resource saved without QR.');
    }
}



    // View resource by scanning QR code
public function viewByQrCode($token)
{
    try {

        
        $resource = Resource::where('access_token', $token)->first();

        if (!$resource) {
            return view('resource.qrError', [
                'message' => 'Invalid or expired QR Code.'
            ]);
        }

       
        return view('resource.viewResource', compact('resource'));

    } catch (\Exception $e) {

        
        return view('resource.qrError', [
            'message' => 'Connection error. Please try again later.'
        ]);
    }
}


    // Download resource file
public function downloadResource($id)
{
    $resource = Resource::findOrFail($id);

    $path = storage_path('app/public/uploads/' . $resource->file_path);

   
    if (!file_exists($path)) {
        return redirect()->back()->with('error', 'File cannot be opened on this device.');
    }

    return response()->download($path);
}

public function search(Request $request)
{
    $query = Resource::query();

    // Search by keyword
    if ($request->has('search') && !empty($request->search)) {
        $keyword = $request->search;
        $query->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('subject', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    // Filter by category
    if ($request->has('category') && !empty($request->category)) {
        $query->where('category', $request->category);
    }

    // Filter by year
    if ($request->has('year') && !empty($request->year)) {
        $query->where('year', $request->year);
    }

    // Filter by subject
    if ($request->has('subject') && !empty($request->subject)) {
        $query->where('subject', $request->subject);
    }

    // Sort
    $sort = $request->get('sort', 'newest');
    if ($sort === 'newest') {
        $query->orderBy('upload_date', 'desc');
    } else if ($sort === 'oldest') {
        $query->orderBy('upload_date', 'asc');
    }

    $resources = $query->paginate(12);

    // Get unique values for filter dropdowns
    $categories = Resource::distinct()->pluck('category')->sort();
    $years = Resource::distinct()->pluck('year')->sort();
    $subjects = Resource::distinct()->pluck('subject')->sort();

    return view('resource.search', compact('resources', 'categories', 'years', 'subjects'));
}


    // Download QR code
    public function downloadQrCode($id)
    {
        $resource = Resource::findOrFail($id);
        
        if (!$resource->qr_code_path) {
            return redirect()->back()->with('error', 'QR code not found. Please generate it first.');
        }

        $filePath = storage_path('app/public/' . $resource->qr_code_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'QR code file not found.');
        }

        return response()->download($filePath, 'QR_' . $resource->title . '.png');
    }

public function browseSubjects(Request $request)
{
    $query = Resource::select('subject', 'category', 'year')
        ->selectRaw('COUNT(*) as resource_count')
        ->groupBy('subject', 'category', 'year')
        ->orderBy('subject');

    // Apply filters
    if ($request->search) {
        $query->where('subject', 'LIKE', '%' . $request->search . '%');
    }

    if ($request->year) {
        $query->where('year', $request->year);
    }

    if ($request->category) {
        $query->whereIn('category', $request->category);
    }

    if ($request->subject) {
        $query->where('subject', $request->subject);
    }

    // Pagination works now
    $subjects = $query->paginate(20);

    $categories = Resource::select('category')->distinct()->pluck('category');
    $subjectList = Resource::distinct()->pluck('subject');


    return view('course.course', compact('subjects', 'categories', 'subjectList'));
}


public function browseSubjectResources($subject)
{
    try {
        $decoded = urldecode($subject);

        $resources = Resource::where('subject', $decoded)->paginate(10);

        if ($resources->count() == 0) {
            // AF1
            return view('course.course-subject', [
                'subject' => $decoded,
                'resources' => [],
                'message' => 'No resources available for this subject.'
            ]);
        }

        return view('course.course-subject', [
            'resources' => $resources,
            'subject' => $decoded
        ]);

    } catch (\Exception $e) {
        // EF1
        return back()->with('error', 'Unable to load content. Please try again later.');
    }
}


}