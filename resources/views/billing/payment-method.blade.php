<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('billing/payment_methods.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])
@section('content')
    <x-grid type="1/1">
        @include('partials.errors')

        <h1 class="">
            {{ __('billing/payment_methods.title') }}
        </h1>
        <p class="text-lg">
            {!! __('settings.subscription.billing.helper', [
                'stripe' => '<a href="https://www.stripe.com" target="_blank">Stripe</a>'
            ]) !!}
        </p>

        <h3 class="">
            {{ __('settings.subscription.billing.saved' )}}
        </h3>
        <div id="billing">
            <billing-management
                    api_token="{{ $stripeApiToken }}"
                    trans="{{ $translations }}"
            ></billing-management>
        </div>


        <x-form :action="['billing.payment-method.save']" method="PATCH" direct>
            <x-grid type="1/1">
                @if (auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')?->ended())
                    @include('settings.subscription.currency._blocked')
                @else
                    <x-forms.field field="currency" :label="__('settings.subscription.fields.currency')">
                        <x-forms.select name="currency" :options="$currencies" :selected="auth()->user()->currency()" />
                    </x-forms.field>

                    <div class="text-right">
                        <x-buttons.confirm type="primary" outline="true">
                            <x-icon class="save" />
                            <span>
                        {{ __('settings.subscription.actions.update_currency') }}</span>
                        </x-buttons.confirm>
                    </div>
                @endif
            </x-grid>
        </x-form>


        <h3 class="">
            {{ __('settings.billing.title') }}
        </h3>
        <x-form :action="['settings.billing-info']" method="PATCH" direct>
            <p class="help-block">
                {{ __('settings.billing.placeholder') }}
            </p>
        <textarea name="profile[billing]" placeholder="" class="w-full rounded border p-2 mb-2" rows="5" maxlength="1024">{!! old('profile[billing]', \Illuminate\Support\Arr::get($user->profile, 'billing')) !!}</textarea>
            <div class="text-right">
                <x-buttons.confirm type="primary"  outline="true">
                    <x-icon class="save" />
                    <span>{{ __('settings.billing.save') }}</span>
                </x-buttons.confirm>
            </div>
        </x-form>
    </x-grid>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/billing.js')
@endsection
