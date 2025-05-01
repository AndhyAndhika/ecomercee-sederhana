<nav class="navbar navbar-expand-lg navbar-light bg-light shadow shadow-sm">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bold" href="{{ route('MarketPlace.index') }}">Haldin <span class="badge bg-info p-2">Product's</span></a>

        <div class="d-flex align-items-center ms-auto gap-3">
            {{-- <style>
                .cart-popover {
                    width: 350px;
                    max-width: 100%;
                }
            </style>
            <a id="cartPopover" href="{{ route('MarketPlace.index') }}" class="text-dark position-relative" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="bottom" data-bs-html="true" title="Keranjang Belanja"
                data-bs-content='
                    <table class="table table-sm mb-2">
                        <thead>
                            <tr><th>Item</th><th>Qty</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Produk A</td><td>2</td></tr>
                            <tr><td>Produk B</td><td>1</td></tr>
                        </tbody>
                    </table>
                    <div class="d-grid">
                        <a href="{{ route("MarketPlace.index") }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-cart-shopping"></i> My Cart </a>
                    </div>
                '>
                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                <span class="badge bg-dark text-light border border-light rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
            </a> --}}

            <a href="{{ route('MarketPlace.myCart') }}" class="text-dark position-relative" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover focus" title="My Cart">
                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                <span class="badge bg-dark text-light border border-light rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
            </a>
            <div class="vr"></div>
            @guest
                <a href="{{ route('login') }}" class="text-dark fs-5" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover focus" title="{{ __('Login') }}">
                    <i class="fa-solid fa-user fa-xl"></i>
                </a>
            @else
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-dark fs-5" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover focus" title="{{ __('Logout') }}">
                    <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest
        </div>
    </div>
</nav>
