@extends('layouts.core')
@push('css')

@endpush
@section('onCore')
    {{-- Navbar --}}
    @include('layouts.components.navbar')

    <div class="container px-1 px-lg-1 my-2">
        <h1>My Cart</h1>
    </div>

    @include('Layouts.components.footerPolos')
@endsection
@push('js')

@endpush
