<header class="bg-transparent">
    <div class="container px-1 px-lg-5 my-5">
        @include('layouts.components.welcomeBack')
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
