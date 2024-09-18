@if ($isYearly)
    @if ($user->subscribed('kanka'))
{{--        <x-helper>--}}
{{--            Looking for the promotion? Unfortunately it is only available for new and returning subscribers.--}}
{{--        </x-helper>--}}
    @else
        <div class="flex flex-col gap-2">
            <div class="field text-left ">
                <label>{{ __('settings.subscription.coupon.label') }}</label>
                <input type="text" name="coupon-check" maxlength="12" id="coupon-check" class="w-full" data-url="{{ route('subscription.check-coupon', ['tier' => $tier]) }}" />
            </div>
            <div id="coupon-validating" class="p-2 text-center hidden">
                <x-icon class="loading" />
            </div>
            <x-alert type="success" :hidden="true" id="coupon-success"></x-alert>
            <x-alert type="warning" :hidden="true" id="coupon-invalid">
                {{ __('settings.subscription.coupon.invalid') }}
            </x-alert>
        </div>
    @endif
@else
{{--    <x-alert type="success">--}}
{{--        Psst! Our yearly subscriptions are 20% of during black friday!--}}
{{--    </x-alert>--}}
@endif
