<div>
<x-box class="mb-12 rounded-2xl">
    <x-slot name="title">
        {{ __('settings.account.2fa.title') }}
    </x-slot>

    @if (session()->has('disable-success'))
        <span class="text-green-600">
            {{ session('disable-success') }}
        </span>
    @endif

    @if ($user->passwordSecurity?->google2fa_enable)
        <p class="hep-block">{{ __('settings.account.2fa.enabled') }}</p>

        <div class="text-right">
            <button wire:click="disable2fa" class="btn2 btn-error"> @if ($clickedBefore) {{ __('settings.account.2fa.actions.disable-confirm') }} @else {{ __('settings.account.2fa.actions.disable') }} @endif  </button>
        </div>
    @else
        @if(auth()->user()->isSocialLogin())
                <p>{{ __('settings.account.2fa.social') }}</p>
        @elseif(empty($user->passwordSecurity))
                <p>
                    {{ __('settings.account.2fa.helper') }} <a href="https://docs.kanka.io/en/latest/account/security/two-factor-authentication.html" class="text-link">{{ __('settings.account.2fa.learn_more') }}</a>
                </p>

                <p>{!! __('settings.account.2fa.enable_instructions', [
                    'android' => '<a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Android</a>',
                    'ios' => '<a target="_blank" href="https://apps.apple.com/us/app/google-authenticator/id388497605">iOS</a>',
                ]) !!}</p>

                <div class="text-right">
                    <button wire:click="generate2faSecretCode" class="btn2 btn-primary"> {{ __('settings.account.2fa.generate_qr') }} </button>
                </div>
        @elseif(!$user->passwordSecurity->google2fa_enable)
                <div>
                    <x-grid type="1/1">
                        <p>{{ __('settings.account.2fa.activation_helper') }}</p>

                        <x-forms.field field="qr-code" required :label="__('settings.account.2fa.fields.qrcode')">
                            {!! $user->passwordSecurity->getGoogleQR() !!}
                        </x-forms.field>
                    </x-grid>
                    <div class="flex flex-wrap gap-2 justify-between items-end">
                        <div class="field field-name">
                            <label>{{__('settings.account.2fa.fields.otp')}}</label>

                            <input type="password" wire:model="otp" name="otp" maxlength="12" class="input rounded text-dark  w-full p-2" />
                            <div>
                                @error('otp') <span class="text-error">{{ $message }}</span> @enderror
                            </div>
                            @if (session()->has('otp-error'))
                                <span class="text-error">
                                    {{ session('otp-error') }}
                                </span>
                            @endif
                        </div>
                        <div class="text-right">
                            <button wire:click="enable2fa" class="btn2 btn-primary"> {{ __('settings.account.2fa.actions.finish') }} </button>
                        </div>
                    </div>
                </div>
       @endif
  @endif
</x-box>
</div>

