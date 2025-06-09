<section id="hero" class="mb-8">
    <div class="container">
        <div class="row roomy">
            <div class="w-full">
                <h1 class="mb-6">{{ $title }}</h1>
                @if (isset($subtitle))
                <p class="text-xl max-w-xl mb-2">{{ $subtitle ?? null }}</p>
                @endif
                {!! $link ?? null !!}
                {!! $slot !!}
            </div>
        </div>
    </div>
</section>
