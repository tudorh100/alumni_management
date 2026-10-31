
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
                    <h1 class="h4 mb-3">Add Announcement</h1>
                    <form method="POST" action="{{ route('admin.storeAnnouncement') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Announcement Title</label>
                            <input type="text" name="title" class="form-control"  required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Announcement Content</label>
                            <textarea name="content" class="form-control" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Add Announcement</button>
                    </form>
                   
                  
                </div>
            </div>
        </div>
    </div>


        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->id }}</td>
                        <td>{{ $announcement->title }}</td>
                        <td class="text-break" style="max-width: 250px;">{{ $announcement->content }}</td>
                        <td>{{ $announcement->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.editAnnouncement', $announcement->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.destroyAnnouncement', $announcement->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this department?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-muted text-center py-3">
                            No Announcement found.
                        </td>
                    </tr>
                @endforelse
                {{-- @empty --}}
                    
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