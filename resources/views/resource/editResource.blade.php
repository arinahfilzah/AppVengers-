@extends('layouts.app')

@section('title', 'Edit Resource')

@section('content')
<div class="container mt-5">
    <h2>Edit Resource</h2>
    <form action="{{ route('resource.update', $resource->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $resource->title }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $resource->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <<select class="form-control" name="category" value="{{ $resource->category }}"  required>
    <option value="Software Engineering" {{ $resource->category == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
    <option value="Data Engineering" {{ $resource->category == 'Data Engineering' ? 'selected' : '' }}>Data Engineering</option>
    <option value="Computer Network & Security" {{ $resource->category == 'Computer Network & Security' ? 'selected' : '' }}>Computer Network & Security</option>
    <option value="Bioinformatic" {{ $resource->category == 'Bioinformatic' ? 'selected' : '' }}>Bioinformatic</option>
    <option value="Graphic & Multimedia" {{ $resource->category == 'Graphic & Multimedia' ? 'selected' : '' }}>Graphic & Multimedia</option>
</select>

        </div>

        <div class="mb-3">
            <label>Year</label>
            <select class="form-control" name="year" value="{{ $resource->year }}" required>
    <option value="Year 1" {{ $resource->year == 'Year 1' ? 'selected' : '' }}>Year 1</option>
    <option value="Year 2" {{ $resource->year == 'Year 2' ? 'selected' : '' }}>Year 2</option>
    <option value="Year 3" {{ $resource->year == 'Year 3' ? 'selected' : '' }}>Year 3</option>
    <option value="Year 4" {{ $resource->year == 'Year 4' ? 'selected' : '' }}>Year 4</option>
</select>

        </div>

        <div class="mb-3">
            <label>Subject</label>
            <select class="form-control subject-select" name="subject" value="{{ $resource->subject }}" required>
    <option value="" disabled>Select or search subject</option>

    <!-- Existing subjects -->
    <option value="Discrete Structure" {{ $resource->subject == 'Discrete Structure' ? 'selected' : '' }}>Discrete Structure</option>
    <option value="Programming Technique I" {{ $resource->subject == 'Programming Technique I' ? 'selected' : '' }}>Programming Technique I</option>
    <option value="Programming Technique II" {{ $resource->subject == 'Programming Technique II' ? 'selected' : '' }}>Programming Technique II</option>
    <option value="Technology & Information System" {{ $resource->subject == 'Technology & Information System' ? 'selected' : '' }}>Technology & Information System</option>
    <option value="Digital Logic" {{ $resource->subject == 'Digital Logic' ? 'selected' : '' }}>Digital Logic</option>
    <option value="Integrity and Anti-Corruption" {{ $resource->subject == 'Integrity and Anti-Corruption' ? 'selected' : '' }}>Integrity and Anti-Corruption</option>
    <option value="Computational Mathematics" {{ $resource->subject == 'Computational Mathematics' ? 'selected' : '' }}>Computational Mathematics</option>
    <option value="Software Engineering" {{ $resource->subject == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
    <option value="Probability & Statiscal Data Analysis" {{ $resource->subject == 'Probability & Statiscal Data Analysis' ? 'selected' : '' }}>Probability & Statiscal Data Analysis</option>
    <option value="Computer Organisation & Architecture" {{ $resource->subject == 'Computer Organisation & Architecture' ? 'selected' : '' }}>Computer Organisation & Architecture</option>
    <option value="Database" {{ $resource->subject == 'Database' ? 'selected' : '' }}>Database</option>
    <option value="System Analysis & Design" {{ $resource->subject == 'System Analysis & Design' ? 'selected' : '' }}>System Analysis & Design</option>
    <option value="Data Structure & Algoritm" {{ $resource->subject == 'Data Structure & Algoritm' ? 'selected' : '' }}>Data Structure & Algoritm</option>
    <option value="Network Communications" {{ $resource->subject == 'Network Communications' ? 'selected' : '' }}>Network Communications</option>
    <option value="Computer Security" {{ $resource->subject == 'Computer Security' ? 'selected' : '' }}>Computer Security</option>
    <option value="Human Computer Interaction" {{ $resource->subject == 'Human Computer Interaction' ? 'selected' : '' }}>Human Computer Interaction</option>
    <option value="Object-Oriented Programming" {{ $resource->subject == 'Object-Oriented Programming' ? 'selected' : '' }}>Object-Oriented Programming</option>
    <option value="Requirements Engineering & Software Modelling" {{ $resource->subject == 'Requirements Engineering & Software Modelling' ? 'selected' : '' }}>Requirements Engineering & Software Modelling</option>
    <option value="Theory of Computer Science" {{ $resource->subject == 'Theory of Computer Science' ? 'selected' : '' }}>Theory of Computer Science</option>
    <option value="Operating Systems" {{ $resource->subject == 'Operating Systems' ? 'selected' : '' }}>Operating Systems</option>
    <option value="Web Programming" {{ $resource->subject == 'Web Programming' ? 'selected' : '' }}>Web Programming</option>
    <option value="Application Development" {{ $resource->subject == 'Application Development' ? 'selected' : '' }}>Application Development</option>
    <option value="Professional Communication Skill I" {{ $resource->subject == 'Professional Communication Skill I' ? 'selected' : '' }}>Professional Communication Skill I</option>
    <option value="Professional Communication Skill II" {{ $resource->subject == 'Professional Communication Skill II' ? 'selected' : '' }}>Professional Communication Skill II</option>
    <option value="Professional Communication Skill III" {{ $resource->subject == 'Professional Communication Skill III' ? 'selected' : '' }}>Professional Communication Skill III</option>

    <!-- Add new button -->
    <option value="add_new">+ Add New Subject</option>
</select>

        </div>

        <div class="mb-3">
            <label>File (leave empty if not changing)</label>
            <input type="file" name="file1" class="form-control">
            <small>Current File: <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" target="_blank">{{ $resource->file_path }}</a></small>
        </div>

        <button type="submit" class="btn btn-success">Update Resource</button>
        <a href="{{ route('manageResource') }}" class="btn btn-secondary">Cancel</a>

    </form>

    <form action="{{ route('resource.destroy', $resource->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" style="float: right;" onclick="return confirm('Are you sure you want to delete this resource?');">Delete Resource</button>
</form>



    
</div>
@endsection
