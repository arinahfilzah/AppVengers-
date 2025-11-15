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

public function create()
{
    return view('resource.uploadResource');
}



}
