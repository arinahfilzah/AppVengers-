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
        'file1' => 'required|file'
    ]);

    // upload file
    $fileName = time() . '_' . $request->file1->getClientOriginalName();
    $request->file1->move(public_path('uploads'), $fileName);

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

    return redirect()->back()->with('success', 'Resource saved!');
}

}
