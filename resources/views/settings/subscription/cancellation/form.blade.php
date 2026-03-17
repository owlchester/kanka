<?php /** @var \App\Models\User $user */ ?>
@php
    $endDate = $user->subscription('kanka')->upcomingInvoice()?->date()->isoFormat('MMMM D, Y');
    $secondaryKeys = [
        'financial'   => ['lower_price', 'not_often', 'forgot'],
        'not_for'     => ['expected_different', 'terminology', 'too_complex', 'better_fit'],
        'not_using'   => ['on_break', 'too_busy', 'lost_motivation'],
        'not_playing' => ['campaign_finished', 'group_fell_apart', 'on_break'],
        'competitor'  => ['world_anvil', 'legend_keeper', 'notion_obsidian', 'other'],
    ];
    $secondaryOptions = [];
    foreach ($secondaryKeys as $primaryReason => $keys) {
        foreach ($keys as $key) {
            $secondaryOptions[$primaryReason][$key] = __('subscriptions/cancellation.secondary.' . $primaryReason . '.' . $key);
        }
    }
@endphp
<x-dialog.header>
    {{ __('settings.subscription.cancel.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container p-4 md:px-6">

    <x-form :action="['settings.subscription.cancel']" id="cancellation-confirm" class="subscription-form text-left">
        <x-grid type="1/1">

            <x-helper>
                <p>{!! __('subscriptions/cancellation.intro', ['date' => $endDate])!!}</p>
            </x-helper>

            <div class="flex flex-col gap-2">
                <span class="font-semibold">
                    {{ __('subscriptions/cancellation.loss.title') }}
                </span>

                @if ($premiumCampaign)
                <div class="flex flex-col gap-0.5">
                    <div>
                        <x-icon class="fa-regular fa-times text-red-500"></x-icon>
                        {{ trans_choice('subscriptions/cancellation.loss.premium.title', $premiumCampaigns->count() - 1, ['campaign' => $premiumCampaign->name, 'count' => $premiumCampaigns->count() - 1 ]) }}
                    </div>
                    @if ($players > 0)
                    <div class="pl-4">
                        <x-icon class="fa-regular fa-arrow-right"></x-icon>
                        {{ trans_choice('subscriptions/cancellation.loss.premium.players', $players, ['count' => $players]) }}
                    </div>
                    @endif
                    @if ($plugins > 0)
                    <div class="pl-4">
                        <x-icon class="fa-regular fa-arrow-right"></x-icon>
                        {{ trans_choice('subscriptions/cancellation.loss.premium.plugins', $plugins, ['count' => $plugins]) }}
                    </div>
                    @endif
                </div>
                @endif

                <div class="flex flex-col gap-0.5">
                    <div>
                        <x-icon class="fa-regular fa-times text-red-500"></x-icon>
                        {{ __('subscriptions/cancellation.loss.ads.title') }}
                    </div>
                </div>

                @if ($discord)
                <div class="flex flex-col gap-0.5">
                    <div>
                        <x-icon class="fa-regular fa-times text-red-500"></x-icon>
                        {{ __('subscriptions/cancellation.loss.discord.title', ['role' => auth()->user()->pledge]) }}
                    </div>
                </div>
                @endif
            </div>

            <div
                x-data="{
                    reason: '',
                    secondary: '',
                    canDowngrade: '{{ !$user->isOwlbear() }}',
                    secondaryOptions: @js($secondaryOptions)
                }"
                x-init="$watch('reason', () => { secondary = '' })"
                class="space-y-4"
            >
                <x-forms.field field="cancel-reason" :label="__('settings.subscription.fields.reason')">
                    @php
                        $reasons = [
                            'financial'        => __('settings.subscription.cancel.options.financial'),
                            'not_for'          => __('settings.subscription.cancel.options.not_for'),
                            'not_using'        => __('settings.subscription.cancel.options.not_using'),
                            'not_playing'      => __('settings.subscription.cancel.options.not_playing'),
                            'missing_features' => __('settings.subscription.cancel.options.missing_features'),
                            'competitor'       => __('settings.subscription.cancel.options.competitor'),
                        ];

                        if ($user->subscription('kanka') && $user->subscription('kanka')->created_at->greaterThanOrEqualTo(\Carbon\Carbon::now()->subHour())) {
                            $reasons['testing'] = __('settings.subscription.cancel.options.testing');
                        }

                        $reasons['custom'] = __('settings.subscription.cancel.options.other');
                    @endphp

                    <div class="flex flex-col gap-2">
                        @foreach($reasons as $value => $label)
                            <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                                <input
                                    type="radio"
                                    name="reason"
                                    id="cancel-reason-{{ $value }}"
                                    value="{{ $value }}"
                                    class="mt-1"
                                    x-model="reason"
                                >
                                <label for="cancel-reason-{{ $value }}" class="w-full cursor-pointer">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </x-forms.field>

                <input type="hidden" name="reason_secondary" :value="secondary">

                <div x-show="secondaryOptions[reason]" x-cloak class="flex flex-col gap-2">
                    <x-forms.field field="cancel-reason" :label="__('subscriptions/cancellation.secondary.label')">
                    <template x-for="[value, label] in Object.entries(secondaryOptions[reason] ?? {})" :key="value">
                        <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                            <input
                                type="radio"
                                :id="'cancel-secondary-' + value"
                                :value="value"
                                class="mt-1"
                                x-model="secondary"
                            >
                            <label :for="'cancel-secondary-' + value" class="w-full cursor-pointer" x-text="label"></label>
                        </div>
                    </template>
                    </x-forms.field>
                </div>

                <div x-show="reason === 'missing_features'" x-cloak>
                    {!! __('subscriptions/cancellation.loss.roadmap', ['roadmap' => '<a href="' . route('roadmap') . '" class="text-link font-semibold">' . __('footer.roadmap') . '</a>']) !!}
                </div>

                <div x-show="reason === 'financial' && canDowngrade" x-cloak>
                    {{ __('subscriptions/cancellation.loss.downgrade') }}
                </div>

                <x-forms.field field="reason_custom" :label="__('subscriptions/cancellation.custom.label')">
                    <textarea
                        name="reason_custom"
                        placeholder="{{ __('subscriptions/cancellation.custom.placeholder') }}"
                        class="w-full"
                        rows="4"
                        id="cancel-reason-custom"
                    ></textarea>
                </x-forms.field>

                <div class="flex flex-col gap-1">
                    <button
                        class="btn2 btn-block subscription-confirm-button"
                        :class="{ 'btn-disabled btn-default': !reason, 'btn-error btn-outline ': reason }"
                        data-text="{{ __('settings.subscription.actions.subscribe') }}"
                        :disabled="!reason"
                    >
                        <span>{{ __('settings.subscription.actions.cancel_sub') }}</span>
                        <span class="spinner hidden">
                            <x-icon class="load" />
                        </span>
                    </button>
                    <p x-show="!reason" x-cloak class="text-xs text-center text-neutral-content">
                        {{ __('subscriptions/cancellation.select_reason') }}
                    </p>
                </div>
            </div>
        </x-grid>
    </x-form>
</article>
