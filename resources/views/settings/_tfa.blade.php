<h3 class="mb-3">
    {{ __('settings.account.2fa.title') }}
</h3>
<div class="rounded p-4 mb-5 bg-box">
    @if ($user->passwordSecurity?->google2fa_enable)
        <p class="hep-block">{{ __('settings.account.2fa.enabled') }}</p>

        <div class="text-right">

            <x-buttons.confirm type="danger" outline="true" target="deactivate-2fa">

                {{ __('settings.account.2fa.actions.disable') }}
            </x-buttons.confirm>
        </div>
    @elseif (!auth()->user()->isSubscriber())
            <p>
                {{ __('settings.account.2fa.helper') }} {!! link_to('https://docs.kanka.io/en/latest/account/security/two-factor-authentication.html', __('settings.account.2fa.learn_more')) !!}
            </p>

            <p>
                {!! __('callouts.subscribe.pitch-2fa', [
                    'more' => link_to_route('front.pricing', __('subscription.benefits.more'), '#paid-features', ['target' => '_blank']),
                    'boosters' => link_to_route('front.boosters', __('subscription.benefits.boosters'), '', ['target' => '_blank'])
                ]) !!}
            </p>
    @elseif (auth()->user()->isSubscriber())
        @if(auth()->user()->isSocialLogin())
                <p>{{ __('settings.account.2fa.social') }}</p>
        @elseif(empty($user->passwordSecurity) && (auth()->user()->isSubscriber() || auth()->user()->subscription('kanka')->canceled()))
                <p>
                    {{ __('settings.account.2fa.helper') }} {!! link_to('https://docs.kanka.io/en/latest/account/security/two-factor-authentication.html', __('settings.account.2fa.learn_more')) !!}
                </p>

                <p>{!! __('settings.account.2fa.enable_instructions', [
                    'android' => link_to('https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2', 'Android', ['target' => '_blank']),
                    'ios' => link_to('https://apps.apple.com/us/app/google-authenticator/id388497605', 'iOS', ['target' => '_blank']),
                ]) !!}</p>
            {!! Form::open(['route' => 'settings.security.generate-2fa', 'method' => 'POST']) !!}
                <div class="text-right">

                    <x-buttons.confirm type="primary" outline="true">
                        {{ __('settings.account.2fa.generate_qr') }}
                    </x-buttons.confirm>
                </div>
            {!! Form::close() !!}
        @elseif(!$user->passwordSecurity->google2fa_enable && auth()->user()->isSubscriber() || auth()->user()->subscription('kanka')->canceled())
            {!! Form::open(['route' => 'settings.security.enable-2fa', 'method' => 'POST']) !!}
                <p>{{ __('settings.account.2fa.activation_helper') }}</p>

                <div class="form-group required">
                    <label>{{ __('settings.account.2fa.fields.qrcode') }}</label><br />
                    {!! $user->passwordSecurity->getGoogleQR() !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('settings.account.2fa.fields.otp') }}</label>
                    {!! Form::password('otp', ['class' => 'form-control', 'maxlength' => 12]) !!}
                </div>

                <div class="text-right">
                    <x-buttons.confirm type="primary" outline="true">
                        {{ __('settings.account.2fa.actions.finish') }}
                    </x-buttons.confirm>
                </div>
            {!! Form::close() !!}
       @endif
  @endif
</div>

@section('modals')
    @parent
    @if($user->passwordSecurity?->google2fa_enable))
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
