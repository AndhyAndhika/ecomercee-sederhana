<header class="bg-transparent">
    <div class="container px-1 px-lg-5 my-5">
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
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">

            <div class="carousel-indicators">
                @foreach ($banner as $item)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->iteration - 1 }}" @if ($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{ $loop->iteration }}"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach ($banner as $item)
                    <div class="carousel-item @if ($loop->first) active @endif">
                        <img src="{{ asset($item->picture) }}" class="d-block w-100" alt="{{ $item->name }}">
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</header>
