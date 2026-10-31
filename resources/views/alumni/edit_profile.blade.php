
@extends('layouts.app')

@section('content')

@include('layouts.headersidebar')
<!--Main layout-->
<main style="margin-top: 50px;">

    <h1 class="h3 mb-4">Welcome back, {{ auth()->user()->name }}</h1>

  <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card shadow-sm">

                <div class="card-body p-4 ">
                    <h1 class="h4 mb-3">Edit Profile</h1>
                    <form method="POST" action="{{ route('alumni.profile.update')}}"   enctype="multipart/form-data">
                        @csrf
                         @method('PUT')

                         <div class="mb-3">
    <label for="name" class="form-label">Full Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
           required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email Address</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}"
           required>
</div>


                        <div class="mb-3">
                        <label class="form-label">Department</label>
                       <select name="department_id" class="form-control" required>
        <option value="">Select Department</option>
        @foreach($Departments as $department)
            <option value="{{ $department->id }}"
                {{ old('department_id', $profile->department_id) == $department->id ? 'selected' : '' }}>
                {{ $department->department }}
            </option>
        @endforeach
    </select>
                        </div>
                         
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="number" name="phone" class="form-control"  
                            value="{{ $profile->phone }}"

                            required>
                        </div>
                         
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control"  required>
                                   @foreach(['male' => 'Male', 'female' => 'Female'] as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                        </div>
                        {{-- restricting the year of birth to be between 19 and 100 years ago from the current date. This ensures that the user is at least 19 years old and not older than 100 years. --}}
                         <div class="mb-3">
                            <label class="form-label">DOB</label>
                              <input type="date" name="dob" id="dob"
                                   class="form-control @error('dob') is-invalid @enderror"
                                   max="{{ now()->subDay()->toDateString() }}"
                                   value="{{ old('dob', \Carbon\Carbon::parse($profile->dob)->format('Y-m-d')) }}" required>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                       </div>
                        </div>
                         <div class="mb-3">
                            <label class="form-label">Graduation Yea</label>
                           <select name="graduation_year" id="graduation_year" class="form-select">

                        <option value="{{ $profile->graduation_year }}">{{ $profile->graduation_year }}</option>
                        @for($year = now()->year + 6; $year >= 1980; $year--)
                                    <option value="{{ $year }}"
                                        {{ $profile->graduation_year }}>
                                        {{ $year }}
                                    </option>
                                @endfor

                       </select>
                         </div>

                          <div class="mb-3">
                            <label class="form-label">CurrentAddress</label>
                            <textarea name="current_address" id="current_address" rows="2" maxlength="500"
                                      class="form-control @error('current_address') is-invalid @enderror"
                                      required>{{ $profile->current_address }}</textarea>
                            @error('current_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror                        </div>


                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" id="bio" rows="3"
                                      class="form-control @error('bio') is-invalid @enderror"
                                      required>{{$profile->bio }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                         <div class="mb-3">
                            <label class="form-label">Photo</label>
                             @if($profile->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/profile_photos/' . $profile->photo) }}"
                                         alt="Current profile photo" width="100" height="100"
                                         class="rounded border" style="object-fit: cover;">
                                    <div><small class="text-muted">Choose a new file only if you want to replace this photo.</small></div>
                                </div>
                            @endif
 
                            <input type="file" name="photo" id="photo"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png">
                            <small class="text-muted">JPG or PNG, max 2MB.</small>
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror                        
                        </div>
                                               
                                                                
                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </form>
                   
                  
                </div>
            </div>
        </div>
    </div>





    </div>


</div>

</main>
<!--Main layout-->

@endsection

<style>
    body {
  background-color: grey;
}
@media (min-width: 991.98px) {
  main {
    padding-left: 240px;
  }
}
main {
  /* background-color: grey; */
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
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

li a {
    text-decoration: none;
}
</style>