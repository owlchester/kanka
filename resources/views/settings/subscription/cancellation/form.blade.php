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

            <div x-data="{ reason: '', canDowngrade: '{{ !$user->isOwlbear() }}'}" class="space-y-2">
                <x-forms.field field="cancel-reason" :label="__('settings.subscription.fields.reason')">
                    <x-grid type="1/1">
                        <select name="reason" id="cancel-reason" class="w-full" x-model="reason">
                            @php
                                $reasons = [
                                    '' => __('crud.select'),
                                    'financial' => __('settings.subscription.cancel.options.financial'),
                                    'not_for' => __('settings.subscription.cancel.options.not_for'),
                                    'not_using' => __('settings.subscription.cancel.options.not_using'),
                                    'not_playing' => __('settings.subscription.cancel.options.not_playing'),
                                    'missing_features' => __('settings.subscription.cancel.options.missing_features'),
                                    'competitor' => __('settings.subscription.cancel.options.competitor'),
                                ];

                                if ($user->subscription('kanka') && $user->subscription('kanka')->created_at->greaterThanOrEqualTo(\Carbon\Carbon::now()->subHour())) {
                                    $reasons['testing'] =  __('settings.subscription.cancel.options.testing');
                                }

                                $reasons['custom'] = __('settings.subscription.cancel.options.other');
                            @endphp

                            @foreach($reasons as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <textarea
                            name="reason_custom"
                            placeholder="{{ __('settings.subscription.placeholders.reason') }}"
                            class="w-full"
                            rows="4"
                            id="cancel-reason-custom"
                            x-show="reason === 'custom'"
                            x-cloak
                        ></textarea>
                    </x-grid>
                </x-forms.field>

                <div x-show="reason === 'missing_features'" x-cloak>
                    </br>
                    {!! __('subscriptions/cancellation.loss.roadmap', ['roadmap' => '<a href="' . route('roadmap') . '">' . __('footer.roadmap') . '</a>']) !!}
                </div>

                <div x-show="reason === 'financial' && canDowngrade" x-cloak>
                    </br>
                    {{ __('subscriptions/cancellation.loss.downgrade') }}
                </div>
            </div>

{{--            <button class="btn2 btn-lg btn-block btn-primary btn-outline subscription-pause-button flex flex-col gap-0.5">--}}
{{--                {{ __('subscriptions/cancellation.pause.button') }}<br />--}}
{{--                <span class="text-xs">--}}
{{--                    {{ __('subscriptions/cancellation.pause.helper') }}--}}
{{--                </span>--}}
{{--            </button>--}}

            <button class="btn2 btn-lg btn-block btn-primary btn-error btn-outline subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                <span>{{ __('settings.subscription.actions.cancel_sub') }}</span>
                <span class="spinner hidden">
                    <x-icon class="load" />
                </span>
            </button>
        </x-grid>
    </x-form>
</article>
