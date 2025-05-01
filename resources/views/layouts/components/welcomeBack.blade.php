@guest
@else
    <div class="d-flex justify-content-between align-items-center ">
        <p class="text-end text-muted fw-semibold mb-3 fs-6">
            👋 Welcome Back, <span class="text-dark">{{ Auth::user()->name }}</span>
        </p>

        @if (Auth::user()->role == 99)
            <a class="btn btn-secondary btn-sm" href="{{ route('home') }}"> <i class="fa-solid fa-tv"></i> Go To Dashboad</a>
        @endif
    </div>
@endguest
