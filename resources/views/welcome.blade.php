<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Alumni Network') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            background: linear-gradient(135deg, #0d3b8c 0%, #1e6fd9 100%);
            color: #fff;
            padding: 110px 0 90px;
        }
        .stat-number { font-size: 2.2rem; font-weight: 700; }
        .feature-card { border: 0; box-shadow: 0 2px 10px rgba(0, 0, 0, .07); }
        .feature-icon {
            width: 52px; height: 52px; border-radius: 50%;
            background: #e8f0fd; color: #0d3b8c;
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1.2rem;
        }
        footer { background: #0b2a63; color: #c9d6ee; }
    </style>
</head>
<body>
@php
    // Returns the route URL if the route exists, otherwise "#" so the page never crashes
    $link = fn ($name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
    $colors = ['general' => 'secondary', 'event' => 'success', 'job' => 'info', 'urgent' => 'danger'];
@endphp

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">{{ config('app.name', 'Alumni Network') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#announcements">Announcements</a></li>
            </ul>

            <div class="d-flex gap-2">
                @auth
                    <a href="{{ $link('alumni.dashboard') }}" class="btn btn-light btn-sm">Dashboard</a>
                @else
                    <a href="{{ $link('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    <a href="{{ $link('register') }}" class="btn btn-light btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="hero" id="home">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Stay connected with your alma mater</h1>
        <p class="lead mb-4 mx-auto" style="max-width: 640px;">
            Join the alumni community. Update your profile, reconnect with classmates
            and keep up with the latest news and opportunities.
        </p>

        @guest
            <a href="{{ $link('register') }}" class="btn btn-light btn-lg me-2">Join the Network</a>
            <a href="{{ $link('login') }}" class="btn btn-outline-light btn-lg">Login</a>
        @else
            <a href="{{ $link('alumni.dashboard') }}" class="btn btn-light btn-lg">Go to Dashboard</a>
        @endguest
    </div>
</section>

{{-- Stats --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="stat-number text-primary">{{ $totalAlumni }}</div>
                <div class="text-muted">Registered Alumni</div>
            </div>
            <div class="col-md-4">
                <div class="stat-number text-primary">{{ $totalDepartments }}</div>
                <div class="text-muted">Departments</div>
            </div>
            <div class="col-md-4">
                <div class="stat-number text-primary">{{ $totalAnnouncements }}</div>
                <div class="text-muted">Announcements</div>
            </div>
        </div>
    </div>
</section>

{{-- About / features --}}
<section class="py-5" id="about">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why join the alumni network?</h2>
            <p class="text-muted">Everything you need to stay connected, in one place.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4 text-center">
                    <div class="feature-icon mx-auto mb-3">1</div>
                    <h5>Build your profile</h5>
                    <p class="text-muted mb-0">Share your department, graduation year and a short bio so others can find you.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4 text-center">
                    <div class="feature-icon mx-auto mb-3">2</div>
                    <h5>Get the latest news</h5>
                    <p class="text-muted mb-0">Receive announcements about events, job opportunities and important updates.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4 text-center">
                    <div class="feature-icon mx-auto mb-3">3</div>
                    <h5>Reconnect</h5>
                    <p class="text-muted mb-0">Stay in touch with classmates and fellow graduates from your department.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Latest announcements --}}
<section class="py-5 bg-light" id="announcements">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Latest Announcements</h2>
            <p class="text-muted">What is happening in the alumni community.</p>
        </div>

        <div class="row g-4">
            @forelse($announcements as $announcement)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm {{ $announcement->is_pinned ? 'border-warning' : '' }}">
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-{{ $colors[$announcement->category] ?? 'secondary' }}">
                                    {{ ucfirst($announcement->category ?? 'general') }}
                                </span>
                                @if($announcement->is_pinned)
                                    <span class="badge bg-warning text-dark">Pinned</span>
                                @endif
                            </div>

                            <h5 class="card-title">{{ $announcement->title }}</h5>
                            <p class="card-text text-muted text-break">
                                {{ \Illuminate\Support\Str::limit($announcement->body ?? $announcement->content ?? '', 120) }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent small text-muted">
                            {{ $announcement->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">No announcements yet. Please check back soon.</div>
            @endforelse
        </div>

        @auth
            <div class="text-center mt-4">
                <a href="{{ $link('alumni.announcements') }}" class="btn btn-primary">View all announcements</a>
            </div>
        @endauth
    </div>
</section>

{{-- Call to action --}}
@guest
<section class="py-5 text-center">
    <div class="container">
        <h3 class="fw-bold mb-3">Ready to reconnect?</h3>
        <p class="text-muted mb-4">Create your account and complete your alumni profile in minutes.</p>
        <a href="{{ $link('register') }}" class="btn btn-primary btn-lg">Register Now</a>
    </div>
</section>
@endguest

{{-- Footer --}}
<footer class="py-4">
    <div class="container text-center small">
        &copy; {{ date('Y') }} {{ config('app.name', 'Alumni Network') }}. All rights reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>