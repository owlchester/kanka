<section id="faq" class="max-w-4xl mx-auto py-16 px-4">
    <h2 class="text-center mb-12">{{ __('subscriptions/faq.title') }}</h2>

    <div class="space-y-4">

        @foreach (['cost', 'methods', 'cancellation', 'renewal', 'trial', 'data' , 'downgrade', 'refund', 'discount', 'sharing', 'security', 'update', 'fail'] as $key)
            <x-faq-element id="{{ $key }}">
                <x-slot name="question">
                    {{ __('subscriptions/faq.' . $key . '.question') }}
                </x-slot>
                <x-slot name="answer">
                    <p>
                        {!! __('subscriptions/faq.' . $key . '.answer', [
    'billing' => '<a href="' . route('billing.payment-method') . '">' . __('billing/menu.payment-method') . '</a>',
    'stripe' => '<a href="https://stripe.com">Stripe</a>',
    'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>'
]) !!}
                    </p>
                </x-slot>
            </x-faq-element>
        @endforeach

    </div>
</section>
