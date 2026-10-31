@extends('layouts.app')

@section('content')
@php
    $colors = ['general' => 'secondary', 'event' => 'success', 'job' => 'info', 'urgent' => 'danger'];

    // Returns the route URL if the route exists, otherwise "#" so the page never crashes
    $link = fn ($name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';

    $maxDepartment = max(1, (int) $byDepartment->max('total'));
@endphp

{{-- Swap this for your admin sidebar include if it is a different file --}}
@include('layouts.headersidebar')

<!--Main layout-->
<main style="margin-top: 50px;">

    <div class="container-fluid py-4">

        {{-- Welcome --}}
        <div class="mb-4 text-white">
            <h4 class="mb-1">Admin Dashboard</h4>
            <p class="mb-0 opacity-75">Welcome back, {{ auth()->user()->name }}. Here is an overview of the alumni system.</p>
        </div>

        {{-- Stat cards --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm h-100 border-start border-4 border-primary">
                    <div class="card-body">
                        <div class="text-muted small">Registered Alumni</div>
                        <div class="fs-2 fw-bold">{{ $totalAlumni }}</div>
                        <div class="small text-muted">with a completed profile</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm h-100 border-start border-4 border-warning">
                    <div class="card-body">
                        <div class="text-muted small">Profiles Pending</div>
                        <div class="fs-2 fw-bold">{{ $pendingProfiles }}</div>
                        <div class="small text-muted">accounts without a profile</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm h-100 border-start border-4 border-success">
                    <div class="card-body">
                        <div class="text-muted small">New This Month</div>
                        <div class="fs-2 fw-bold">{{ $newThisMonth }}</div>
                        <div class="small text-muted">profiles added in {{ now()->format('F') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm h-100 border-start border-4 border-info">
                    <div class="card-body">
                        <div class="text-muted small">Departments / Announcements</div>
                        <div class="fs-2 fw-bold">{{ $totalDepartments }} / {{ $totalAnnouncements }}</div>
                        <div class="small text-muted">departments and posts</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex flex-wrap gap-2">
                <a href="{{ $link('admin.showalumni') }}" class="btn btn-primary btn-sm">View All Alumni</a>
                <a href="{{ $link('admin.createdepartment') }}" class="btn btn-outline-primary btn-sm">Add Department</a>
                <a href="{{ $link('admin.department') }}" class="btn btn-outline-primary btn-sm">Manage Departments</a>
                <a href="{{ $link('admin.addAnnouncement') }}" class="btn btn-outline-success btn-sm">Post Announcement</a>
                
                <a href="{{ route('admin.alumni.export.pdf') }}"
   class="btn btn-danger">
    Export All Alumni to PDF
</a>



                {{-- <a href="{{ $link('admin.announcements') }}" class="btn btn-outline-secondary btn-sm">Manage Announcements</a> --}}
            </div>
        </div>

        <div class="row g-4">

            {{-- Alumni by department --}}
            <div class="col-lg-5">
                <div class="card shadow-sm h-100">
                    <div class="card-header fw-semibold">Alumni by Department</div>
                    <div class="card-body">
                        @forelse($byDepartment as $row)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small">
                                    <span>{{ $row->department?->department ?? 'No department' }}</span>
                                    <span class="fw-semibold">{{ $row->total }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ round($row->total / $maxDepartment * 100) }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No alumni profiles yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Recent registrations --}}
            <div class="col-lg-7">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Recent Alumni</span>
                        <a href="{{ $link('admin.showalumni') }}" class="small">View all</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Year</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAlumni as $profile)
                                    <tr>
                                        <td>
                                            @if($profile->photo)
                                                <img src="{{ asset('storage/profile_photos/' . $profile->photo) }}"
                                                     alt="Photo" width="40" height="40"
                                                     class="rounded-circle" style="object-fit: cover;">
                                            @else
                                                <span class="text-muted small">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $profile->user?->name }}
                                            <div class="small text-muted">{{ $profile->user?->email }}</div>
                                        </td>
                                        <td>{{ $profile->department?->department }}</td>
                                        <td>{{ $profile->graduation_year }}</td>
                                        <td class="text-nowrap small">{{ $profile->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No alumni yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Latest announcements --}}
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Latest Announcements</span>
                        <a href="{{ $link('admin.announcements') }}" class="small">Manage</a>
                    </div>

                    <div class="list-group list-group-flush">
                        @forelse($announcements as $announcement)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="me-3">
                                    <span class="badge bg-{{ $colors[$announcement->category] ?? 'secondary' }}">
                                        {{ ucfirst($announcement->category ?? 'general') }}
                                    </span>
                                    <span class="fw-semibold ms-1">{{ $announcement->title }}</span>
                                    <div class="small text-muted text-break">
                                        {{ \Illuminate\Support\Str::limit($announcement->body ?? $announcement->content ?? '', 120) }}
                                    </div>
                                </div>
                                <small class="text-muted text-nowrap">{{ $announcement->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted py-4">No announcements yet.</div>
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