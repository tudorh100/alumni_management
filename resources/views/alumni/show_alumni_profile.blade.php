
@extends('layouts.app')

@section('content')

@include('layouts.headersidebar')
<!--Main layout-->
<main style="margin-top: 50px;">

    <h1 class="h3 mb-4">Welcome back, {{ auth()->user()->name }}</h1>

 



    <div class="table-responsive bg-white rounded shadow-sm">


        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                    <th>Name of Department</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Graduation Year</th>
                    <th>Current Address</th>
                    <th>Bio</th>
                    <th>Photo</th>


                    <th>Action</th></tr></thead>
            <tbody>
                {{-- @forelse ($departments as $department) --}}
                    <tr>
                        <td>{{ $profile->user->name }}</td>
                        <td>{{ $profile->user->email }}</td>
                        <td>{{ $profile->department->department}}</td>
                        <td>{{ $profile->phone }}</td>
                        <td>{{ $profile->gender }}</td>
                        <td>{{ $profile->dob }}</td>
                        <td>{{ $profile->graduation_year }}</td>
                        <td>{{ $profile->current_address }}</td>
                        <td>{{ $profile->bio }}</td>
                    <td> 
                        @if($profile->photo)
        <img src="{{ asset('storage/profile_photos/' . $profile->photo) }}"
             alt="Profile photo"
             width="60" height="60"
             class="rounded-circle"
             style="object-fit: cover;">
    @else
        <span class="text-muted">No photo</span>
    @endif
</td>
                        <td>
                            <a href="{{ route('alumni.edit_profile', $profile->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            {{-- <form action="{{ route('admin.destroy_department', $department->id) }}" method="POST" class="d-inline"> --}}
                               
                        </td>
                    </tr>
             
                   
            </tbody>
        </table>
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