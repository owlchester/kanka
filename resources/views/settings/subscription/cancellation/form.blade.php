<?php /** @var \App\Models\User $user */ ?>
@php
    $endDate = $user->subscription('kanka')->upcomingInvoice()?->date()->isoFormat('MMMM D, Y');
@endphp
<x-dialog.header>
    {{ __('settings.subscription.cancel.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container p-4 md:px-6">

    <x-form :action="['settings.subscription.cancel']" id="cancellation-confirm" class="subscription-form text-left">
        <x-grid type="1/1">

            <x-helper>
                <p>{!! __('settings.subscription.cancel.text', ['date' => $endDate])!!}</p>
            </x-helper>

            <x-forms.field field="cancel-reason" :label="__('settings.subscription.fields.reason')">
                <x-grid type="1/1">
                    @php $reasons = [
                        '' => __('crud.select'),
                        'financial' => __('settings.subscription.cancel.options.financial'),
                        'not_for' => __('settings.subscription.cancel.options.not_for'),
                        'not_using' => __('settings.subscription.cancel.options.not_using'),
                        'not_playing' => __('settings.subscription.cancel.options.not_playing'),
                        'missing_features' => __('settings.subscription.cancel.options.missing_features'),
                        'competitor' => __('settings.subscription.cancel.options.competitor'),
                    ];

                    if ($user->subscription('kanka') && $user->subscription('kanka')->created_at->greaterThanOrEqualTo(Carbon\Carbon::now()->subHour())) {
                        $reasons['testing'] =  __('settings.subscription.cancel.options.testing');
                    }

                    $reasons['custom'] = __('settings.subscription.cancel.options.other');
                    @endphp
                    <x-forms.select name="reason" :options="$reasons" class="w-full" />
                    <textarea name="reason_custom" placeholder="{{ __('settings.subscription.placeholders.reason') }}" class="w-full" rows="4" id="cancel-reason-custom"></textarea>
                </x-grid>
            </x-forms.field>

            <button class="btn2 btn-lg btn-block btn-primary btn-error btn-outline subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                <span>{{ __('settings.subscription.actions.cancel_sub') }}</span>
                <span class="spinner hidden">
                    <x-icon class="load" />
                </span>
            </button>
        </x-grid>
    </x-form>
</article>
