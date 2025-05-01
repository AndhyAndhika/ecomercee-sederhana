@extends('layouts.core')
@push('css')

@endpush
@section('onCore')
    {{-- Navbar --}}
    @include('layouts.components.navbar')

    <div class="container px-1 px-lg-1 my-5">
        @include('layouts.components.welcomeBack')
        <div class="row">
            {{-- List Cart --}}
            <div class="col-12">
                <x-table id="Cart">
                    <x-slot name="thead">
                        <tr>
                            <th width="5%" class="text-center align-middle"><input type="checkbox" style="width: 1.5rem; height: 1.5rem;" class="form-check-input" id="checkAll" name="checkAll"></th>
                            <th width="15%" class="text-center align-middle">Picture</th>
                            <th width="35%" class="text-center align-middle">Product</th>
                            <th width="20%" class="text-center align-middle">Qty</th>
                            <th width="20%" class="text-center align-middle">Price</th>
                            <th width="5%" class="text-center align-middle">Act</th>
                        </tr>
                    </x-slot>
                    <x-slot name="tbody">
                        @if ($cart->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center align-middle">
                                    <div class="alert alert-info" role="alert">
                                        <i class="fa-solid fa-cart-shopping fa-lg me-2"></i>
                                        Your cart is empty
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($cart as $item)
                            <tr>
                                <td class="text-center align-middle">
                                    <input type="checkbox" style="width: 1.5rem; height: 1.5rem;" class="item-checkbox form-check-input" id="check{{ $item->id }}" name="check{{ $item->id }}" data-id="{{ $item->id }}" data-stock="{{ $item->product->stock }}" data-price="{{ $item->product->price }}">
                                </td>
                                <td class="text-center align-middle">
                                    <img class="img-thumbnail" style="max-width: 7rem; height: auto;" src="{{ asset($item->product->picture) }}" alt="{{ $item->product->name }}">
                                </td>
                                <td class="align-middle">{{ $item->product->name }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <div class="input-group input-group-sm shadow-sm rounded" style="width: 120px;">
                                            <button class="btn btn-outline-dark border-0" type="button" onclick="changeQty({{ $item->id }}, -1, {{ $item->product->stock }})">
                                                <i class="fa-solid fa-minus fa-sm"></i>
                                            </button>
                                            <input class="form-control text-center border-0 fw-semibold" id="inputQuantity{{ $item->id }}" type="number" name="qty[{{ $item->id }}]" value="{{ $item->qty ?? 1 }}" min="1" style="font-size: 14px;"/>
                                            <button class="btn btn-outline-dark border-0" type="button" onclick="changeQty({{ $item->id }}, 1, {{ $item->product->stock }})">
                                                <i class="fa-solid fa-plus fa-sm"></i>
                                            </button>
                                        </div>
                                        <div class="text-muted small">Stock: {{ $item->product->stock }} pcs</div>
                                        <div class="text-danger small" id="stockWarning{{ $item->id }}">

                                        </div>
                                    </div>
                                </td>

                                <td class="text-center align-middle">
                                    @rupiah($item->product->price)
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-danger btn-sm" type="button" onclick="deleteItem({{ $item->id }})">
                                        <i class="fa-solid fa-trash fa-sm"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </x-slot>
                </x-table>
            </div>

            {{-- grand Price  --}}
            <div class="col-12">
                <x-table id="Cart">
                    <x-slot name="thead">
                        <tr>
                            <th width="80%" class="text-end align-middle">Grand Price</th>
                            <th width="20%" class="text-center align-middle" id="grandPrice">Rp 0</th>
                        </tr>
                    </x-slot>
                    <x-slot name="tbody">

                    </x-slot>
                </x-table>
            </div>

            {{-- Button Checkout --}}
            <div class="col-12 d-flex justify-content-end mb-3">
                @if ($cart->isNotEmpty())
                    <button class="btn btn-success" id="btn-payNow" type="button" onclick="payNow()">
                        <i class="fa-solid fa-money-bill-wave fa-lg me-2"></i>
                        Pay Now
                    </button>
                @endif
            </div>
    </div>

    @include('Layouts.components.footerPolos')
@endsection
@push('js')
    <script>
        /* ketika checkbox "Check All" diklik */
        $('#checkAll').on('change', function () {
            $('.item-checkbox').prop('checked', this.checked);
            countGrandPrice(); // update total
        });

        /* ketika salah satu checkbox item diklik, update status "Check All" */
        $('.item-checkbox').on('change', function () {
            const allChecked = $('.item-checkbox').length === $('.item-checkbox:checked').length;
            $('#checkAll').prop('checked', allChecked);
            countGrandPrice(); // update total
        });

        /* function change qty for each item */
        const changeQty = (id, amount, maxStock) => {
            const $input = $(`#inputQuantity${id}`);
            const $warning = $(`#stockWarning${id}`);

            let current = parseInt($input.val()) || 1;
            let newValue = current + amount;

            if (newValue >= maxStock) {
                newValue = maxStock;
                $warning.removeClass('d-none').html('Maximum stock reached');
            } else {
                $warning.addClass('d-none');
            }

            if (newValue < 1) newValue = 1;

            $input.val(newValue);
            countGrandPrice();
        }

        /* count grand price */
        const countGrandPrice = () => {
            let total = 0;

            $('.item-checkbox:checked').each(function () {
                const id = $(this).data('id');
                const price = parseFloat($(this).data('price'));
                const qty = parseInt($(`#inputQuantity${id}`).val()) || 1;

                total += price * qty;
            });

            $('#grandPrice').text(formatRupiah(total));
        };

        /* delete item on cart */
        const deleteItem = (id) => {
            $.ajax({
                url: "{{ route('MarketPlace.removeFromCart') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function (res) {
                    toastr.error(res.message, 'Error!', {timeOut: 3000})
                    reloadPageAfterTimeout(1000);
                },
                error: function (xhr) {
                    toastr.error('Terjadi kesalahan saat menambahkan produk ke keranjang.', 'Error!', {timeOut: 3000})
                    reloadPageAfterTimeout(1000);
                }
            });
        }

        /* function checkout alias Pay Now */
        const payNow = () => {
            $('#btn-payNow').attr('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');

            /* get data cart */
            let cart = [];
            let isValid = true;

            $('.item-checkbox:checked').each(function () {
                const id = $(this).data('id');
                const stock = parseInt($(this).data('stock'));
                const qty = parseInt($(`#inputQuantity${id}`).val()) || 1;

                if (qty > stock) {
                    $(`#stockWarning${id}`).html('*Cannot exceed stock');
                    toastr.error('Quantity cannot exceed stock', 'Error!', {timeOut: 3000})
                    isValid = false;
                } else {
                    $(`#stockWarning${id}`).html('');
                }

                cart.push({
                    id: id,
                    qty: qty
                });
            });

            if (!isValid) {
                toastr.error('Please check your cart.', 'Error!', {timeOut: 3000})
                $('#btn-payNow').attr('disabled', false).html('<i class="fa-solid fa-money-bill-wave fa-lg me-2"></i> Pay Now');
                return;
            }


            /* check if cart is empty */
            if (cart.length === 0) {
                toastr.error('Please select at least one item to checkout.', 'Error!', {timeOut: 3000})
                $('#btn-payNow').attr('disabled', false).html('<i class="fa-solid fa-money-bill-wave fa-lg me-2"></i> Pay Now');
                return;
            }

            /* send data to server */
            $.ajax({
                url: "{{ route('MarketPlace.checkout') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    cart: cart,
                },
                beforeSend: function () {
                    $('#btn-payNow').attr('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');
                },
                success: function (res) {
                    if (res.status == 'success') {
                        toastr.success(res.message, 'Success!', {timeOut: 3000})
                    } else {
                        toastr.error(res.message, 'Error!', {timeOut: 3000})
                    }
                    reloadPageAfterTimeout(1000);
                },
                error: function (xhr) {
                    toastr.error('Terjadi kesalahan saat menambahkan produk ke keranjang.', 'Error!', {timeOut: 3000})
                    reloadPageAfterTimeout(1000);
                }
            });
        }
    </script>
@endpush
