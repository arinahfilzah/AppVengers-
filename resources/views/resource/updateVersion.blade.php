@extends('layouts.app')

@section('title', 'Edit Resource')

@section('content')

<section class="page-header">
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 pb-5 text-center">
                <h1 class="mb-0 bread">Update Resource With Versioning</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Current Version Info Card --}}
                <div class="card mb-4 shadow-sm" style="border-left: 4px solid #4986fc;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #4986fc;">
                            <i class="fa fa-info-circle"></i> Current Version: v{{ $resource->current_version ?? 1 }}
                        </h5>
                        <p class="mb-2"><strong>Title:</strong> {{ $resource->title }}</p>
                        <p class="mb-2"><strong>Current File:</strong> {{ $resource->file_path }}</p>
                        <p class="mb-2"><strong>Total Versions:</strong> {{ $resource->versions ? $resource->versions->count() : 1 }}</p>
                        @if($resource->versions && $resource->versions->count() > 0)
                        <a href="{{ route('resource.versionHistory', $resource->id) }}" class="btn btn-sm btn-info mt-2">
                            <i class="fa fa-history"></i> View Version History
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Update Form --}}
                <div class="card shadow-sm">
                    <div class="card-header" style="background: #4986fc; color: white;">
                        <h5 class="mb-0"><i class="fa fa-edit"></i> Save New Version</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('resource.storeNewVersion', $resource->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Title --}}
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $resource->title) }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"
                                    rows="3">{{ old('description', $resource->description) }}</textarea>
                            </div>

                            {{-- Category --}}
                            <div class="mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control @error('category') is-invalid @enderror"
                                    id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Software Engineering" {{ old('category', $resource->category) == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                                    <option value="Data Engineering" {{ old('category', $resource->category) == 'Data Engineering' ? 'selected' : '' }}>Data Engineering</option>
                                    <option value="Computer Network & Security" {{ old('category', $resource->category) == 'Computer Network & Security' ? 'selected' : '' }}>Computer Network & Security</option>
                                    <option value="Bioinformatic" {{ old('category', $resource->category) == 'Bioinformatic' ? 'selected' : '' }}>Bioinformatic</option>
                                    <option value="Graphic & Multimedia" {{ old('category', $resource->category) == 'Graphic & Multimedia' ? 'selected' : '' }}>Graphic & Multimedia</option>
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Year --}}
                            <div class="mb-3">
                                <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                <select class="form-control @error('year') is-invalid @enderror"
                                    id="year" name="year" required>
                                    <option value="">Select Year</option>
                                    <option value="Year 1" {{ old('year', $resource->year) == 'Year 1' ? 'selected' : '' }}>Year 1</option>
                                    <option value="Year 2" {{ old('year', $resource->year) == 'Year 2' ? 'selected' : '' }}>Year 2</option>
                                    <option value="Year 3" {{ old('year', $resource->year) == 'Year 3' ? 'selected' : '' }}>Year 3</option>
                                    <option value="Year 4" {{ old('year', $resource->year) == 'Year 4' ? 'selected' : '' }}>Year 4</option>
                                </select>
                                @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Subject --}}
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <select class="form-control subject-select @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" required>
                                    <option value="" disabled>Select or search subject</option>

                                    <!-- All your existing subjects -->
                                    <option value="Discrete Structure" {{ old('subject', $resource->subject) == 'Discrete Structure' ? 'selected' : '' }}>Discrete Structure</option>
                                    <option value="Programming Technique I" {{ old('subject', $resource->subject) == 'Programming Technique I' ? 'selected' : '' }}>Programming Technique I</option>
                                    <option value="Programming Technique II" {{ old('subject', $resource->subject) == 'Programming Technique II' ? 'selected' : '' }}>Programming Technique II</option>
                                    <option value="Technology & Information System" {{ old('subject', $resource->subject) == 'Technology & Information System' ? 'selected' : '' }}>Technology & Information System</option>
                                    <option value="Digital Logic" {{ old('subject', $resource->subject) == 'Digital Logic' ? 'selected' : '' }}>Digital Logic</option>
                                    <option value="Integrity and Anti-Corruption" {{ old('subject', $resource->subject) == 'Integrity and Anti-Corruption' ? 'selected' : '' }}>Integrity and Anti-Corruption</option>
                                    <option value="Computational Mathematics" {{ old('subject', $resource->subject) == 'Computational Mathematics' ? 'selected' : '' }}>Computational Mathematics</option>
                                    <option value="Software Engineering" {{ old('subject', $resource->subject) == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                                    <option value="Probability & Statiscal Data Analysis" {{ old('subject', $resource->subject) == 'Probability & Statiscal Data Analysis' ? 'selected' : '' }}>Probability & Statiscal Data Analysis</option>
                                    <option value="Computer Organisation & Architecture" {{ old('subject', $resource->subject) == 'Computer Organisation & Architecture' ? 'selected' : '' }}>Computer Organisation & Architecture</option>
                                    <option value="Database" {{ old('subject', $resource->subject) == 'Database' ? 'selected' : '' }}>Database</option>
                                    <option value="System Analysis & Design" {{ old('subject', $resource->subject) == 'System Analysis & Design' ? 'selected' : '' }}>System Analysis & Design</option>
                                    <option value="Data Structure & Algoritm" {{ old('subject', $resource->subject) == 'Data Structure & Algoritm' ? 'selected' : '' }}>Data Structure & Algoritm</option>
                                    <option value="Network Communications" {{ old('subject', $resource->subject) == 'Network Communications' ? 'selected' : '' }}>Network Communications</option>
                                    <option value="Computer Security" {{ old('subject', $resource->subject) == 'Computer Security' ? 'selected' : '' }}>Computer Security</option>
                                    <option value="Human Computer Interaction" {{ old('subject', $resource->subject) == 'Human Computer Interaction' ? 'selected' : '' }}>Human Computer Interaction</option>
                                    <option value="Object-Oriented Programming" {{ old('subject', $resource->subject) == 'Object-Oriented Programming' ? 'selected' : '' }}>Object-Oriented Programming</option>
                                    <option value="Requirements Engineering & Software Modelling" {{ old('subject', $resource->subject) == 'Requirements Engineering & Software Modelling' ? 'selected' : '' }}>Requirements Engineering & Software Modelling</option>
                                    <option value="Theory of Computer Science" {{ old('subject', $resource->subject) == 'Theory of Computer Science' ? 'selected' : '' }}>Theory of Computer Science</option>
                                    <option value="Operating Systems" {{ old('subject', $resource->subject) == 'Operating Systems' ? 'selected' : '' }}>Operating Systems</option>
                                    <option value="Web Programming" {{ old('subject', $resource->subject) == 'Web Programming' ? 'selected' : '' }}>Web Programming</option>
                                    <option value="Application Development" {{ old('subject', $resource->subject) == 'Application Development' ? 'selected' : '' }}>Application Development</option>
                                    <option value="Professional Communication Skill I" {{ old('subject', $resource->subject) == 'Professional Communication Skill I' ? 'selected' : '' }}>Professional Communication Skill I</option>
                                    <option value="Professional Communication Skill II" {{ old('subject', $resource->subject) == 'Professional Communication Skill II' ? 'selected' : '' }}>Professional Communication Skill II</option>
                                    <option value="Professional Communication Skill III" {{ old('subject', $resource->subject) == 'Professional Communication Skill III' ? 'selected' : '' }}>Professional Communication Skill III</option>

                                    <!-- Add new button -->
                                    <option value="add_new">+ Add New Subject</option>
                                </select>
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New File  --}}
                            <div class="mb-3">
                                <label for="file1" class="form-label">
                                    Upload New File <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control @error('file1') is-invalid @enderror"
                                    id="file1" name="file1" accept=".jpg,.jpeg,.png,.pdf,.docx" required>
                                <small class="text-muted d-block mb-1">
                                    Current File: <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" target="_blank">{{ $resource->file_path }}</a>
                                </small>
                                <small class="text-muted">Supported formats: JPG, PNG, PDF, DOCX (Max: 5MB)</small>
                                @error('file1')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Change Notes --}}
                            <div class="mb-3">
                                <label for="change_notes" class="form-label">
                                    Change Notes <span class="text-muted">(What's new in this version?)</span>
                                </label>
                                <textarea class="form-control" id="change_notes" name="change_notes"
                                    rows="2" placeholder="e.g., Fixed errors on page 5, Added new examples"></textarea>
                                <small class="text-muted">This will help others understand what changed</small>
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('manageResource') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Cancel
                                    </a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Update Resource
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Delete Section --}}
                <div class="card mt-4 shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fa fa-exclamation-triangle"></i> Danger Zone</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Once you delete this resource, there is no going back. All versions will be permanently deleted. Please be certain.</p>
                        <form action="{{ route('resource.destroy', $resource->id) }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fa fa-trash"></i> Delete Resource Permanently
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            html: `
            <p>You are about to delete this resource permanently.</p>
            <p class="text-danger"><strong>All versions and the QR code will be deleted!</strong></p>
            <p>This action cannot be undone.</p>
        `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete It!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>

@endsection