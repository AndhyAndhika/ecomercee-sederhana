<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Setup Title --}}
    <title>{{ $title ?? 'E-commerce Haldin' }}</title>

    {{-- Setup Icon --}}
    <link rel="icon" type="image/webp" sizes="192x192" href="{{ asset('favicon/favicon-192x192.webp') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    {{-- Untuk Keperluan SEO --}}
    <meta name="robots" content="index, follow"> {{-- Meta Tags Dasar --}}
    <meta name="description" content="@yield('meta_description', 'Program ini dibuat sebagai technical test untuk posisi IT Programmer di Haldin Indonesia.')" />
    <meta name="keywords" content="@yield('meta_keywords', 'Program ini dibuat sebagai technical test untuk posisi IT Programmer di Haldin Indonesia.')" />
    <meta name="author" content="@yield('meta_author', 'Andhika Nur R - IT')">
    <link rel="canonical" href="{{ url('/') }}"> {{-- Canonical URL (Untuk Menghindari Duplicate Content) --}}
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}"> {{-- Sitemap URL --}}

    {{-- Untuk Styling --}}
    <link href="https://fonts.bunny.net/css?family=poppins" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/630a92c5e5.js" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    @stack('css')
</head>
<body>

    @yield('onCore')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Success!', {timeOut: 3000})
        @elseif(session('error'))
            toastr.error('{{ session('error') }}', 'Error!', {timeOut: 3000})
        @elseif(session('info'))
            toastr.info('{{ session('info') }}', 'Info!', {timeOut: 3000})
        @endif
    </script>
    @stack('js')
</body>
</html>
