<h3 class="mb-3">
    {{ __('settings.account.2fa.title') }}
</h3>
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
                    {{ __('settings.account.2fa.helper') }} {!! link_to('https://docs.kanka.io/en/latest/account/security/two-factor-authentication.html', __('settings.account.2fa.learn_more')) !!}
                </p>

                <p>{!! __('settings.account.2fa.enable_instructions', [
                    'android' => link_to('https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2', 'Android', ['target' => '_blank']),
                    'ios' => link_to('https://apps.apple.com/us/app/google-authenticator/id388497605', 'iOS', ['target' => '_blank']),
                ]) !!}</p>
            {!! Form::open(['route' => 'settings.security.generate-2fa', 'method' => 'POST']) !!}
                <div class="text-right">
                    <x-buttons.confirm type="primary">
                        {{ __('settings.account.2fa.generate_qr') }}
                    </x-buttons.confirm>
                </div>
            {!! Form::close() !!}
        @elseif(!$user->passwordSecurity->google2fa_enable)
            {!! Form::open(['route' => 'settings.security.enable-2fa', 'method' => 'POST']) !!}
                <x-grid type="1/1">
                    <p>{{ __('settings.account.2fa.activation_helper') }}</p>

                    <x-forms.field field="qr-code" :required="true" :label="__('settings.account.2fa.fields.qrcode')">
                        {!! $user->passwordSecurity->getGoogleQR() !!}
                    </x-forms.field>

                    <x-forms.field field="otp" :required="true" :label="__('settings.account.2fa.fields.otp')">
                        {!! Form::password('otp', ['class' => 'form-control', 'maxlength' => 12]) !!}
                    </x-forms.field>

                    <div class="text-right">
                        <x-buttons.confirm type="primary">
                            {{ __('settings.account.2fa.actions.finish') }}
                        </x-buttons.confirm>
                    </div>
                </x-grid>
            {!! Form::close() !!}
       @endif
  @endif

<hr />

@section('modals')
    @parent
    @if($user->passwordSecurity?->google2fa_enable)
    {!! Form::model($user, ['method' => 'POST', 'route' => ['settings.security.disable-2fa']]) !!}
    <x-dialog id="deactivate-2fa" :title="__('settings.account.2fa.disable.title')">
        <p class="mb-2">
            {{ __('settings.account.2fa.disable.helper') }}
        </p>
        <div class="w-full">
            <x-buttons.confirm type="danger" outline="true" full="true">
                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                {{ __('crud.click_modal.confirm') }}
            </x-buttons.confirm>
        </div>
    </x-dialog>
    {!! Form::close() !!}
    @endif
@endsection
