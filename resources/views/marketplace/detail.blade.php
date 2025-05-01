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
    @include('layouts.components.navbar', ['countCart' => $countCart])

    {{-- Section Product Detail --}}
    <section class="py-1">
        <div class="container px-4 px-lg-5 mt-3 mb-5">
            @include('layouts.components.welcomeBack')
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ asset($product->picture) }}" alt="{{ $product->name }}" /></div>
                <div class="col-md-6">
                    <p class="fs-2 fw-bolder">{{ $product->name }}</p>
                    <div class="fs-5 mb-3">
                        <span class="text-decoration-line-through">@rupiah($product->price + ($product->price * 0.25))</span>
                        <span> @rupiah($product->price)</span>
                    </div>
                    <p class="mb-4"> <span class="fw-bold">Description :</span> <br> {{ $product->description }}</p>

                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <label for="inputQuantity" class="mb-0 fw-semibold text-muted" style="min-width: 40px;">Qty</label>
                                <div class="input-group input-group-sm flex-nowrap shadow-sm rounded" style="width: 120px;">
                                    <button class="btn btn-outline-dark border-0" type="button" onclick="changeQty(-1)"><i class="fa-solid fa-minus fa-lg"></i></button>
                                    <input class="form-control text-center border-0" id="inputQuantity" type="number" value="1" min="1" style="font-weight: 500;" />
                                    <button class="btn btn-outline-dark border-0" type="button" onclick="changeQty(1)"><i class="fa-solid fa-plus fa-lg"></i></button>
                                </div>
                            </div>
                            <div class="text-muted small ms-3">Stok: {{ $product->stock }} pcs</div>
                            <div class="text-danger small ms-5" id="stockWarning"> @if ($product->stock < 1) Out of stock @endif </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-dark" onclick="addToCart({{ $product->id }} ,`{{ $product->slug }}`)" type="button">
                                <i class="fa-solid fa-cart-shopping me-2"></i>
                                Add to cart
                            </button>
                        </div>
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
        /* for quantity maximum buy */
        const changeQty = (amount) => {
            const $qtyInput = $('#inputQuantity');
            const $stockWarning = $('#stockWarning');
            const maxStock = {{ $product->stock }};

            let current = parseInt($qtyInput.val()) || 1;
            let newValue = current + amount;

            if (newValue >= maxStock) {
                newValue = maxStock;
                $stockWarning.removeClass('d-none').text("*Reached maximum stock limit.");
            } else {
                $stockWarning.addClass('d-none');
            }

            if (newValue < 1) newValue = 1;

            $qtyInput.val(newValue);
        }

        /* function for add to cart */
        const addToCart = (item, slug) => {
            @guest
                window.location.href = "{{ route('login') }}";
            @else
                let qty = $('#inputQuantity').val();
                $.ajax({
                    url: "{{ route('MarketPlace.addToCart') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: item,
                        slug: slug,
                        qty: qty
                    },
                    success: function (res) {
                        if (res.status == 'success') {
                            toastr.success(res.message, 'Success!', {timeOut: 3000})
                            $('#cartCount').text(res.cartCount);
                        } else {
                            toastr.error(res.message, 'Error!', {timeOut: 3000})
                            reloadPageAfterTimeout(1000);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Terjadi kesalahan saat menambahkan produk ke keranjang.', 'Error!', {timeOut: 3000})
                        reloadPageAfterTimeout(1000);
                    }
                });
            @endguest
        }
    </script>
@endpush
