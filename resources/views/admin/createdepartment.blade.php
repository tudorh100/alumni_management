
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
                    <h1 class="h4 mb-3">Add Department</h1>
                    <form method="POST" action="{{ route('admin.store_department') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control"  required>
                        </div>
                        
                                                                
                        <button type="submit" class="btn btn-primary w-100">Add Department</button>
                    </form>
                   
                  
                </div>
            </div>
        </div>
    </div>



<h2 class="h5 mb-3">Departments</h2>
    <div class="table-responsive bg-white rounded shadow-sm">

{{-- Search and Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

 <form method="GET" action="{{ route('admin.department') }}">

            <div class="row g-2">

                <div class="col-md-8">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search department..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
                </div>

                <div class="col-md-2">
                    <a href=""
                       class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>

            </div>

        </form>
          </div>
</div>
{{-- //end of search form --}}




        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr><th>S/N</th>
                    <th>Name of Department</th>
                    <th>Action</th>
                </tr></thead>
            <tbody>
                @forelse ($departments as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->department }}</td>
                        <td>
                            <a href="" class="btn btn-sm btn-outline-primary">Edit</a>
                            
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-muted text-center py-3">
                            No departments found.
                        </td>
                    </tr>
                @endforelse
                {{-- @empty --}}
                    <tr><td colspan="3" class="text-muted text-center py-3">
                        You have not made any department yet. </td></tr>
                {{-- @endforelse --}}
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