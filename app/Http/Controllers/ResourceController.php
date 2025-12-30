<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

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

        $resource = Resource::create([
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'year'        => $request->year,
            'subject'     => $request->subject,
            'file_path'   => $fileName,
            'current_version' => 1,
            'upload_date' => now(),
            'uploader_id' => auth()->id(),
        ]);

        // Create initial version record
        ResourceVersion::create([
            'resource_id' => $resource->id,
            'version_number' => 1,
            'file_path' => $fileName,
            'change_notes' => 'Initial upload',
            'updated_by' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Resource successfully added!');
    }

    public function manageResource()
    {
        $user = auth()->user();

        $resources = Resource::where(function ($query) use ($user) {
            $query->where('uploader_id', $user->id)
                ->orWhereHas('collaborators', fn($q) => $q->where('user_id', $user->id));
        })
            ->with('versions')
            ->get();

        return view('resource.manageResource', compact('resources'));
    }
    private function canEdit(Resource $resource)
    {
        return $resource->uploader_id === auth()->id() || $resource->collaborators->contains('user_id', auth()->id());
    }




    public function edit($id)
    {
        $resource = Resource::with(['versions', 'collaborators'])->findOrFail($id);

        if (!$this->canEdit($resource)) {
            return redirect()->route('manageResource')->with('error', 'Unauthorized access.');
        }

        return view('resource.editResource', compact('resource'));
    }


    public function update(Request $request, $id)
    {

        $resource = Resource::with('collaborators')->findOrFail($id);
        if (!$this->canEdit($resource)) {
            return redirect()->route('manageResource')->with('error', 'Unauthorized access.');
        }


        if ($resource->uploader_id !== auth()) {
            return redirect()->route('manageResource')->with('error', 'Unauthorized access.');
        }

        // AF2: Validate required fields
        $request->validate([
            'title' => 'required',
            'file1' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',
            'category' => 'required',
            'year' => 'required',
            'subject' => 'required',
        ], [
            'title.required' => 'Please complete all required fields',
            'category.required' => 'Please complete all required fields',
            'year.required' => 'Please complete all required fields',
            'subject.required' => 'Please complete all required fields',
            'file1.mimes' => 'Unsupported File Format. Only jpg, png, pdf, or docx files are allowed.',
            'file1.max' => 'File size cannot exceed 5MB.',
        ]);

        // NF11: If new file uploaded, create new version
        if ($request->hasFile('file1')) {
            $fileName = time() . '_' . $request->file1->getClientOriginalName();
            $request->file1->storeAs('uploads', $fileName, 'public');

            // Increment version
            $newVersion = $resource->current_version + 1;

            // NF12: Create version record with details
            ResourceVersion::create([
                'resource_id' => $resource->id,
                'version_number' => $newVersion,
                'file_path' => $fileName,
                'change_notes' => $request->change_notes ?? 'Updated resource file',
                'updated_by' => auth()->id(),
                'created_at' => now(),
            ]);

            // Update current file and version
            $resource->file_path = $fileName;
            $resource->current_version = $newVersion;
        }

        // NF8: Update metadata
        $resource->title = $request->title;
        $resource->description = $request->description;
        $resource->category = $request->category;
        $resource->year = $request->year;
        $resource->subject = $request->subject;
        $resource->save();

        // NF13: Success message
        return redirect()->route('resource.manageResource')->with('version_success', 'Resource updated successfully! New version: v' . $resource->current_version);
    }

    public function showUploadForm()
    {
        return view('resource.uploadResource');
    }

    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);

        // Check ownership
        if ($resource->uploader_id !== auth()) {
            return redirect()->route('resource.manageResource')->with('error', 'Unauthorized access.');
        }

        // Delete current file
        if ($resource->file_path && Storage::disk('public')->exists('uploads/' . $resource->file_path)) {
            Storage::disk('public')->delete('uploads/' . $resource->file_path);
        }

        // Delete all version files
        foreach ($resource->versions as $version) {
            if ($version->file_path && Storage::disk('public')->exists('uploads/' . $version->file_path)) {
                Storage::disk('public')->delete('uploads/' . $version->file_path);
            }
        }

        // Delete QR code
        if ($resource->qr_code_path && Storage::disk('public')->exists($resource->qr_code_path)) {
            Storage::disk('public')->delete($resource->qr_code_path);
        }

        $resource->delete();

        return redirect()->route('manageResource')->with('success', 'Resource deleted successfully!');
    }


    public function showVersionHistory($id)
    {
        $resource = Resource::with(['versions.updater'])->findOrFail($id);

        // Check ownership
        if ($resource->uploader_id !== auth()->id()) {
            return redirect()->route('manageResource')->with('error', 'Unauthorized access.');
        }

        return view('resource.versionHistory', compact('resource'));
    }

    // Download specific version
    public function downloadVersion($resourceId, $versionNumber)
    {
        $resource = Resource::findOrFail($resourceId);
        $version = ResourceVersion::where('resource_id', $resourceId)
            ->where('version_number', $versionNumber)
            ->firstOrFail();

        $path = storage_path('app/public/uploads/' . $version->file_path);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Version file not found.');
        }

        return response()->download($path, 'v' . $versionNumber . '_' . $version->file_path);
    }

    // Restore specific version as current
    public function restoreVersion($resourceId, $versionNumber)
    {
        $resource = Resource::findOrFail($resourceId);

        // Check ownership
        if ($resource->uploader_id !== auth()) {
            return redirect()->route('manageResource')->with('error', 'Unauthorized access.');
        }

        $version = ResourceVersion::where('resource_id', $resourceId)
            ->where('version_number', $versionNumber)
            ->firstOrFail();

        // Create new version with old file
        $newVersion = $resource->current_version + 1;

        ResourceVersion::create([
            'resource_id' => $resource->id,
            'version_number' => $newVersion,
            'file_path' => $version->file_path,
            'change_notes' => 'Restored from version ' . $versionNumber,
            'updated_by' => auth()->id(),
            'created_at' => now(),
        ]);

        $resource->update([
            'file_path' => $version->file_path,
            'current_version' => $newVersion,
        ]);

        return redirect()->route('resource.versionHistory', $resourceId)
            ->with('success', 'Version ' . $versionNumber . ' restored successfully as v' . $newVersion);
    }

    public function showUpdateVersionForm($id)
    {
        $resource = Resource::with('versions')->findOrFail($id);

        // Permission check
        if (!$this->canEdit($resource)) {
            abort(403);
        }

        return view('resource.updateVersion', compact('resource'));
    }

    public function storeNewVersion(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        if (!$this->canEdit($resource)) {
            abort(403);
        }

        $request->validate([
            'file' => 'required|mimes:pdf,docx,pptx|max:10240',
            'change_notes' => 'required|string|max:255'
        ]);

        // Calculate next version
        $nextVersion = $resource->current_version + 1;

        // Store file
        $path = $request->file('file')
            ->store("resources/{$resource->id}", 'public');

        // Save version
        ResourceVersion::create([
            'resource_id' => $resource->id,
            'version_number' => $nextVersion,
            'file_path' => $path,
            'change_notes' => $request->change_notes,
            'updated_by' => auth()->id(),
        ]);

        // ✅ UPDATE MAIN RESOURCE (THIS IS THE KEY)
        $resource->update([
            'current_version' => $nextVersion,
            'file_path' => $path
        ]);


        return redirect()
            ->route('resource.versionHistory', $resource->id)
            ->with('version_success', 'New version uploaded successfully.');
    }



    // Generate QR Code for existing resource
    public function generateQrCode($id)
    {
        $resource = Resource::findOrFail($id);

        if (!$resource->access_token) {
            $resource->access_token = Str::random(32);
            $resource->save();
        }

        $qrContent = url('/r/' . $resource->access_token);

        $qrCode = new QrCode(
            data: $qrContent,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        );

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $path = 'qrcodes/qr_' . $resource->id . '.png';
        Storage::disk('public')->put($path, $result->getString());

        $resource->update([
            'qr_code_path' => $path
        ]);

        return redirect()
            ->route('manageResource')
            ->with([
                'qr_success' => 'QR code generated successfully for "' . $resource->title . '"!',
                'qr_resource_id' => $resource->id
            ]);
    }

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

        if ($request->has('search') && !empty($request->search)) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('subject', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        if ($request->has('year') && !empty($request->year)) {
            $query->where('year', $request->year);
        }

        if ($request->has('subject') && !empty($request->subject)) {
            $query->where('subject', $request->subject);
        }

        $sort = $request->get('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('upload_date', 'desc');
        } else if ($sort === 'oldest') {
            $query->orderBy('upload_date', 'asc');
        }

        $resources = $query->paginate(12);
        $categories = Resource::distinct()->pluck('category')->sort();
        $years = Resource::distinct()->pluck('year')->sort();
        $subjects = Resource::distinct()->pluck('subject')->sort();

        return view('resource.search', compact('resources', 'categories', 'years', 'subjects'));
    }

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
            return back()->with('error', 'Unable to load content. Please try again later.');
        }
    }
}
