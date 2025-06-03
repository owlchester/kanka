@php use Illuminate\Support\Arr; @endphp
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
    <x-hero>
        <x-slot name="title">
            {{ __('billing/payment_methods.title') }}
        </x-slot>
        <x-slot name="subtitle">
            {!! __('settings.subscription.billing.helper', [
                'stripe' => '<a href="https://www.stripe.com" target="_blank">Stripe</a>'
            ]) !!}
        </x-slot>
    </x-hero>

    @include('partials.errors')

    <x-box class="mb-12" id="billing">
        <x-slot name="title">
            {{ __('settings.subscription.billing.saved') }}
        </x-slot>

        <billing-management
                api_token="{{ $stripeApiToken }}"
                trans="{{ $translations }}"
        ></billing-management>
    </x-box>

    <x-box class="mb-12" id="currency">
        <x-slot name="title">{{ __('settings.subscription.fields.currency') }}
        </x-slot>

        <x-form :action="['billing.payment-method.save']" method="PATCH" direct>
            <x-grid type="1/1">
                @if (auth()->user()->subscribed('kanka'))
                    @include('settings.subscription.currency._blocked')
                @else
                    @if (auth()->user()->subscription('kanka')?->ended())
                        @include('settings.subscription.currency._reset')
                    @endif
                    <x-forms.field field="currency" :label="__('settings.subscription.fields.currency')">
                        <x-forms.select name="currency" :options="$currencies" :selected="auth()->user()->currency()" />
                    </x-forms.field>
                    @if (auth()->user()->subscription('kanka')?->ended())
                        <x-forms.field field="reset_billing" required :label=" __('settings.subscription.fields.reset')">
                            <input type="hidden" name="reset_billing" value="0" />
                            <x-checkbox :text="__('settings.subscription.fields.reset_billing')">
                                <input type="checkbox" name="reset_billing" value="1" required/>
                            </x-checkbox>
                        </x-forms.field>
                    @endif
                    <div class="text-right">
                        <x-buttons.confirm type="primary">
                            <x-icon class="save" />
                            <span>
                        {{ __('settings.subscription.actions.update_currency') }}</span>
                        </x-buttons.confirm>
                    </div>
                @endif
            </x-grid>
        </x-form>
    </x-box>


    <x-box class="mb-12">
        <x-slot name="title">
            {{ __('settings.billing.title') }}
        </x-slot>

        <div class="flex flex-col gap-4">
            <div class="flex gap-2 justify-between">
                @if (\Illuminate\Support\Arr::exists($user->profile ?? [], 'billing'))
                    <x-helper>
                        <p>{!! nl2br($user->profile['billing']) !!}</p>
                    </x-helper>
                @else
                    <x-helper>
                        <p>{{ __('billing/information.helper') }}</p>
                    </x-helper>
                @endif
                <div class="">
                    <button class="btn2 btn-outline" data-toggle="dialog" data-target="primary-dialog" data-url="{{  route('account.billing.info') }}">
                        {{ __('billing/information.actions.update') }}
                    </button>
                </div>
            </div>
        </div>
    </x-box>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/billing.js')
@endsection
