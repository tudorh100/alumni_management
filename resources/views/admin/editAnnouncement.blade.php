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
                    <h1 class="h4 mb-3">Update Announcement</h1>

                    {{-- Validation errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.updateAnnouncement', $announcement->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Announcement Title</label>
                            <input type="text" name="title" class="form-control"
                                   maxlength="150"
                                   value="{{ old('title', $announcement->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Announcement Content</label>
                            <textarea name="content" class="form-control" rows="6" required>{{ old('content', $announcement->content) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">Update Announcement</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary w-100">Cancel</a>
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