<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Alumni Management</title>

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('boot5/css/bootstrap.min.css') }}">

    {{-- Optional custom styles --}}
    <link rel="stylesheet" href="{{ asset('boot5/css/carousel.css') }}">
</head>

<body>

    {{-- Header --}}
    
    {{-- Page Content --}}
    
    {{-- @include('layouts.headersidebar') --}}
    {{-- Flash Messages --}}
    <div class="container mt-5">
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
    </div>
    @yield('content')

    
    <style>

        .container {
    margin-left: 210px;   /* change to your sidebar's real width */
    padding: 20px;
     margin-left: 250px;               /* your sidebar width */
    width: calc(100% - 250px);        /* not 100%, or it overflows the screen */
    overflow-x: auto;                 /* not hidden */
    padding: 20px;
}
    </style>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('boot5/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>
