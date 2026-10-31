@extends('layouts.app')

@section('content')
@php
    $colors = ['general' => 'secondary', 'event' => 'success', 'job' => 'info', 'urgent' => 'danger'];

    // Returns the route URL if the route exists, otherwise "#" so the page never crashes
    $link = fn ($name, $params = []) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : '#';
@endphp

@include('layouts.headersidebar')

<!--Main layout-->
<main style="margin-top: 50px;">

    <div class="container-fluid py-4">

        {{-- Welcome --}}
        <div class="mb-4 text-white">
            <h4 class="mb-1">Welcome back, {{ $user->name }}</h4>
            <p class="mb-0 opacity-75">Here is a quick look at your alumni account.</p>
        </div>

        {{-- Profile reminder (only when no profile exists yet) --}}
        @if(!$profile)
            <div class="alert alert-warning d-flex justify-content-between align-items-center">
                <span>You have not completed your alumni profile yet.</span>
                <a href="{{ $link('alumni.profile') }}" class="btn btn-sm btn-dark">Add Profile</a>
            </div>
        @endif

        {{-- Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Registered Alumni</div>
                        <div class="fs-2 fw-bold">{{ $totalAlumni }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Alumni in Your Department</div>
                        <div class="fs-2 fw-bold">{{ $sameDepartment }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Announcements</div>
                        <div class="fs-2 fw-bold">{{ $totalAnnouncements }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Profile summary --}}
            <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        @if($profile)
                            @if($profile->photo)
                                <img src="{{ asset('storage/profile_photos/' . $profile->photo) }}"
                                     alt="Profile photo" width="110" height="110"
                                     class="rounded-circle mb-3 border" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width: 110px; height: 110px; font-size: 2.5rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif

                            <h5 class="mb-0">{{ $user->name }}</h5>
                            <p class="text-muted small mb-3">{{ $user->email }}</p>

                            <ul class="list-unstyled text-start small mb-3">
                                <li class="mb-1"><strong>Department:</strong> {{ $profile->department?->department ?? 'Not set' }}</li>
                                <li class="mb-1"><strong>Graduation Year:</strong> {{ $profile->graduation_year }}</li>
                                <li class="mb-1"><strong>Phone:</strong> {{ $profile->phone }}</li>
                            </ul>

                            {{-- Profile completion --}}
                            <div class="text-start mb-3">
                                <div class="d-flex justify-content-between small">
                                    <span>Profile completion</span>
                                    <span>{{ $completion }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $completion == 100 ? 'bg-success' : 'bg-warning' }}"
                                         role="progressbar" style="width: {{ $completion }}%;"></div>
                                </div>
                            </div>

                            <a href="{{ $link('alumni.show_alumni_profile') }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                            <a href="{{ $link('alumni.edit_profile') }}" class="btn btn-sm btn-primary">Edit Profile</a>
                        @else
                            <div class="py-4 text-muted">
                                <p class="mb-3">Add your details so other alumni can find you.</p>
                                <a href="{{ $link('alumni.profile') }}" class="btn btn-primary">Add Profile</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Latest announcements --}}
            <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Latest Announcements</span>
                        <a href="{{ $link('alumni.announcements') }}" class="small">View all</a>
                    </div>

                    <div class="list-group list-group-flush">
                        @forelse($announcements as $announcement)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="me-3">
                                        <span class="badge bg-{{ $colors[$announcement->category] ?? 'secondary' }}">
                                            {{ ucfirst($announcement->category ?? 'general') }}
                                        </span>
                                        @if($announcement->is_pinned)
                                            <span class="badge bg-warning text-dark">Pinned</span>
                                        @endif
                                        @if($announcement->created_at->gt(now()->subDays(7)))
                                            <span class="badge bg-primary">New</span>
                                        @endif

                                        <h6 class="mt-2 mb-1">{{ $announcement->title }}</h6>
                                        <p class="small text-muted mb-0 text-break">
                                            {{ \Illuminate\Support\Str::limit($announcement->body ?? $announcement->content ?? '', 150) }}
                                        </p>
                                    </div>
                                    <small class="text-muted text-nowrap">{{ $announcement->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted py-4">
                                No announcements yet. Please check back soon.
                            </div>
                        @endforelse
                    </div>
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