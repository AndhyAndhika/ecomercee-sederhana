<nav class="navbar navbar-expand-lg navbar-light bg-light shadow shadow-sm">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bold" href="{{ route('MarketPlace.index') }}">Haldin <span class="badge bg-info p-2">Product's</span></a>

        <div class="d-flex align-items-center ms-auto gap-3">
            <a href="{{ route('MarketPlace.myCart') }}" class="text-dark position-relative" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover focus" title="My Cart">
                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                <span class="badge bg-dark text-light border border-light rounded-pill position-absolute top-0 start-100 translate-middle" id="cartCount">{{ $countCart ?? 0 }}</span>
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
