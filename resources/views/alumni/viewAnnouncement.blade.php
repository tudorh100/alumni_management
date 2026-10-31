@extends('layouts.app')

@section('content')
@php
    $colors = ['general' => 'secondary', 'event' => 'success', 'job' => 'info', 'urgent' => 'danger'];
@endphp

@include('layouts.headersidebar')

<!--Main layout-->
<main style="margin-top: 50px;">

    <div class="container-fluid py-4">
        <div class="mb-4">
            <h4 class="mb-1">Announcements</h4>
            <p class="text-muted mb-0">The latest news and updates for alumni.</p>
        </div>

        <div class="row g-4">
            @forelse($announcements as $announcement)
                <div class="col-12 col-xl-10">
                    <div class="card shadow-sm {{ $announcement->is_pinned ? 'border-warning' : '' }}">
                        <div class="card-body p-4">

                            {{-- Badges --}}
                            <div class="mb-2">
                                <span class="badge bg-{{ $colors[$announcement->category] ?? 'secondary' }}">
                                    {{ ucfirst($announcement->category ?? 'general') }}
                                </span>
                                @if($announcement->is_pinned)
                                    <span class="badge bg-warning text-dark">Pinned</span>
                                @endif
                                @if($announcement->created_at->gt(now()->subDays(7)))
                                    <span class="badge bg-primary">New</span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <h3 class="card-title mb-2">{{ $announcement->title }}</h3>

                            <p class="text-muted small mb-3">
                                Posted {{ $announcement->created_at->format('d M Y, h:i A') }}
                                ({{ $announcement->created_at->diffForHumans() }})
                            </p>

                            {{-- Full content --}}
                            <div class="text-break" style="line-height: 1.7;">
                                {!! nl2br(e($announcement->body ?? $announcement->content ?? '')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        No announcements yet. Please check back soon.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $announcements->links() }}
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