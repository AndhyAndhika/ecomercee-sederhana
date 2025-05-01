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

    {{-- Section Product Detail --}}
    <section class="py-1">
        <div class="container px-4 px-lg-5 mt-3 mb-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ asset($product->picture) }}" alt="{{ $product->name }}" /></div>
                <div class="col-md-6">
                    <p class="fs-2 fw-bolder">{{ $product->name }}</p>
                    <div class="fs-5 mb-5">
                        <span class="text-decoration-line-through">@rupiah($product->price + ($product->price * 0.25))</span>
                        <span> @rupiah($product->price)</span>
                    </div>
                    <p class="lead">{{ $product->description }}</p>
                    <div class="d-flex">
                        <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                        <button class="btn btn-outline-dark flex-shrink-0" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Another Product --}}
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Another products</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($anotherProduct as $item)
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
