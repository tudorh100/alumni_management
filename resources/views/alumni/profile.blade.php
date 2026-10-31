@extends('layouts.app')

@section('content')

@include('layouts.headersidebar')

<!--Main layout-->
<main style="margin-top: 50px;">

    <h1 class="h3 mb-4 text-white">Welcome back, {{ auth()->user()->name }}</h1>

    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">Add Profile</h1>

                    {{-- Show every validation error, so a failed save is never silent --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('alumni.profile.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Department --}}
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select name="department_id" class="form-control" required>
                                <option value="">Select Department</option>
                                @foreach($Departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" class="form-control"
                                   inputmode="numeric" minlength="10" maxlength="11"
                                   value="{{ old('phone') }}" required>
                        </div>

                        {{-- Gender --}}
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        {{-- DOB: between 19 and 100 years ago --}}
                        <div class="mb-3">
                            <label class="form-label">DOB</label>
                            <input type="date" name="dob" class="form-control"
                                   value="{{ old('dob') }}"
                                   min="{{ now()->subYears(100)->format('Y-m-d') }}"
                                   max="{{ now()->subYears(19)->format('Y-m-d') }}" required>
                        </div>

                        {{-- Graduation year --}}
                        <div class="mb-3">
                            <label class="form-label">Graduation Year</label>
                            <select name="graduation_year" id="graduation_year" class="form-select" required>
                                <option value="">Select Graduation Year</option>
                                @for ($year = now()->year; $year >= 1962; $year--)
                                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label class="form-label">Current Address</label>
                            <textarea name="current_address" class="form-control" rows="3" required>{{ old('current_address') }}</textarea>
                        </div>

                        {{-- Bio --}}
                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" rows="3" maxlength="1000" required>{{ old('bio') }}</textarea>
                        </div>

                        {{-- Photo --}}
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png" required>
                            <small class="text-muted">JPG or PNG, max 2MB.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Add Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
<!--Main layout-->

<style>
    body {
        background-color: grey;
    }

    @media (min-width: 991.98px) {
        main {
            padding-left: 240px;
        }
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        padding: 58px 0 0; /* Height of navbar */
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
        width: 240px;
        z-index: 600;
    }

    @media (max-width: 991.98px) {
        .sidebar {
            width: 100%;
        }
    }

    .sidebar .active {
        background-color: blue;
        border-radius: 5px;
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: 0.5rem;
        overflow-x: hidden;
        overflow-y: auto;
    }

    li a {
        text-decoration: none;
    }
</style>
@endsection