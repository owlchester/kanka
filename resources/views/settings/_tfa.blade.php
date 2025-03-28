<x-box class="mb-12 rounded-2xl">
    <x-slot name="title">
        {{ __('settings.account.2fa.title') }}
    </x-slot>

    @if ($user->passwordSecurity?->google2fa_enable)
        <p class="hep-block">{{ __('settings.account.2fa.enabled') }}</p>

        <div class="text-right">
            <x-buttons.confirm type="danger" outline="true" target="deactivate-2fa">
                {{ __('settings.account.2fa.actions.disable') }}
            </x-buttons.confirm>
        </div>
    @else
        @if(auth()->user()->isSocialLogin())
                <p>{{ __('settings.account.2fa.social') }}</p>
        @elseif(empty($user->passwordSecurity))
                <p>
                    {{ __('settings.account.2fa.helper') }} <a href="https://docs.kanka.io/en/latest/account/security/two-factor-authentication.html">{{ __('settings.account.2fa.learn_more') }}</a>
                </p>

                <p>{!! __('settings.account.2fa.enable_instructions', [
                    'android' => '<a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Android</a>',
                    'ios' => '<a target="_blank" href="https://apps.apple.com/us/app/google-authenticator/id388497605">iOS</a>',
                ]) !!}</p>
                <x-form action="settings.security.generate-2fa">
                <div class="text-right">
                    <x-buttons.confirm type="primary">
                        {{ __('settings.account.2fa.generate_qr') }}
                    </x-buttons.confirm>
                </div>
            </x-form>
        @elseif(!$user->passwordSecurity->google2fa_enable)
            <x-form action="settings.security.enable-2fa">
                <x-grid type="1/1">
                    <p>{{ __('settings.account.2fa.activation_helper') }}</p>

                    <x-forms.field field="qr-code" required :label="__('settings.account.2fa.fields.qrcode')">
                        {!! $user->passwordSecurity->getGoogleQR() !!}
                    </x-forms.field>
                </x-grid>
                <div class="flex flex-wrap gap-2 justify-between items-end">
                    <x-forms.field field="otp" required :label="__('settings.account.2fa.fields.otp')">
                        <input type="password" name="otp" maxlength="12" />
                    </x-forms.field>

                        <x-buttons.confirm type="primary">
                            {{ __('settings.account.2fa.actions.finish') }}
                        </x-buttons.confirm>
                </div>
            </x-form>
       @endif
  @endif
</x-box>

@section('modals')
    @parent
    @if($user->passwordSecurity?->google2fa_enable)
        <x-form :action="['settings.security.disable-2fa']">
            <x-dialog id="deactivate-2fa" :title="__('settings.account.2fa.disable.title')">
                <p class="">
                    {{ __('settings.account.2fa.disable.helper') }}
                </p>
                <div class="w-full">
                    <x-buttons.confirm type="danger" outline="true" full="true">
                        <x-icon class="fa-solid fa-exclamation-triangle" />
                        {{ __('crud.actions.confirm') }}
                    </x-buttons.confirm>
                </div>
            </x-dialog>
        </x-form>
    @endif
@endsection
