<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

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
        $path = $request->file1->storeAs('uploads', $fileName, 'public');

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

    // if a new file uploaded
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

    // Delete file from storage if exists
    if ($resource->file_path && file_exists(storage_path('app/public/uploads/' . $resource->file_path))) {
        unlink(storage_path('app/public/uploads/' . $resource->file_path));
    }

    // Delete the resource from database
    $resource->delete();

    return redirect()->route('manageResource')->with('success', 'Resource deleted successfully!');
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




}


