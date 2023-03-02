<section class="minimal-padding ab-testing-b bg-primary" id="pricing-faq">
    <div class="container">
        <h2>{{ __('front/pricing.faq.title') }}</h2>
        <p class="lead">{{ __('front/pricing.faq.description') }}</p>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-5">
                    <h3 id="payment-methods" class="h5 font-weight-bold">{{ __('front/pricing.faq.methods.title') }}</h3>
                    <p>{{ __('front/pricing.faq.methods.answer') }}</p>
                </div>

                <div class="mb-5">
                    <h3 id="security" class="h5 font-weight-bold">{{ __('front/pricing.faq.security.title') }}</h3>
                    <p>{{ __('front/pricing.faq.security.answer') }}</p>
                </div>

                <div class="mb-5">
                    <h3 id="cancellation" class="h5 font-weight-bold">{{ __('front/pricing.faq.cancellation.title') }}</h3>
                    <p>{{ __('front/pricing.faq.cancellation.answer') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-5">
                    <h3 id="resub" class="h5 font-weight-bold">{{ __('front/pricing.faq.resub.title') }}</h3>
                    <p>{{ __('front/pricing.faq.resub.answer') }}</p>
                </div>

                <div class="mb-5">
                    <h3 id="refund-policy" class="h5 font-weight-bold">{{ __('front/pricing.faq.refund.title') }}</h3>
                    <p>{!! __('front/pricing.faq.refund.answer', ['amount' => 14, 'email' => link_to('mailto:' . config('app.email'), config('app.email'))]) !!}</p>
                </div>

                <div class="mb-5">
                    <h3 id="gift" class="h5 font-weight-bold">{{ __('front/pricing.faq.gift.title') }}</h3>
                    <p>{{ __('front/pricing.faq.gift.answer') }}</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="#pricing" class="btn btn-large btn-primary">{{ __('front.actions.back-to-top') }}</a>
        </div>
    </div>
</section>

