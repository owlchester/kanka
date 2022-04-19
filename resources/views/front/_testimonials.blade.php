<section id="testimonials" class="bg-primary" @if(!\App\Facades\DataLayer::groupB())style="display: none"@endif>
    <div class="container">
        <div class="section-heading text-center">
            <h2>{{ __('front/testimonials.title') }}</h2>
            <p class="text-muted">{{ __('front/testimonials.description') }}</p>
        </div>
        <div class="mt-5">
            <div class="items">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Laura "Wadue"</h5>
                        <p class="card-text">{{ __('front/testimonials.laura') }}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Charalampos Koundourakis</h5>
                        <p class="card-text">{{ __('front/testimonials.charalampos') }}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ornstein</h5>
                        <p class="card-text">{{ __('front/testimonials.ornstein') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
