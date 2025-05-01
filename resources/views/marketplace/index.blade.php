@extends('layouts.core')
@push('css')
    <style>
        .cardProduct {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .cardProduct:hover {
            cursor: pointer;
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); /* Tambahkan shadow saat hover */
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }
    </style>
@endpush
@section('onCore')
    {{-- Navbar --}}
    @include('layouts.components.navbar')

    {{-- Header Banner --}}
    @include('layouts.components.banner', compact('banner'))

    {{-- Section Product --}}
    <section class="py-1">
        <div class="container px-4 px-lg-5 mt-1 mb-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($product as $item)
                    <div class="col mb-5">
                        <a href="{{ route('MarketPlace.detailProduct', ['slug' => Str::slug($item->name)]) }}" class="card-link">
                            <div class="card h-100 cardProduct d-flex flex-column" href="{{ route('MarketPlace.detailProduct', ['slug' => Str::slug($item->name)]) }}">
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">-20%</div>
                                <img class="card-img-top" src="{{ asset($item->picture) }}" alt="{{ $item->name }}" />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h6 class="fw-bolder">{{ $item->name }}</h5>
                                    </div>
                                </div>
                                <div class="card-footer mt-auto p-3 pt-0 border-top-0 bg-transparent">
                                    <p class="text-center text-dark fs-5">
                                        <span class="text-muted text-decoration-line-through">@rupiah($item->price + ($item->price * 0.25))</span>
                                        @rupiah($item->price)
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('layouts.components.footerPolos')
@endsection
@push('js')
    <script>
        let IntervalSlider = 3000;

        /* buat si banner auto slider setiap 3 detik yang dibungkus IntervalSlider */
        setInterval(() => {
            $('.carousel-control-next').trigger('click');
        }, IntervalSlider);
    </script>
@endpush
