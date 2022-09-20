<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('settings.account.2fa.title') }}
        </h3>
    </div>
    @if ($user->passwordSecurity?->google2fa_enable)
        <div class="box-body">
            <p class="hep-block">{{ __('settings.account.2fa.enabled') }}</p>
        </div>

        <div class="box-footer text-right">
            <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#deactivate-2fa">
                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i> {{ __('settings.account.2fa.disable') }}
            </button>
        </div>
    @elseif (!auth()->user()->isPatron())
        <div class="box-body">
            <p>
                {!! __('callouts.subscribe.pitch-2fa', [
                    'more' => link_to_route('front.pricing', __('subscription.benefits.more'), '#paid-features', ['target' => '_blank']),
                    'boosters' => link_to_route('front.boosters', __('subscription.benefits.boosters'), '', ['target' => '_blank'])
                ]) !!}
            </p>
        </div>
    @elseif (auth()->user()->isPatron())
        @if(auth()->user()->isSocialLogin())
            <div class="box-body">
                <p class="text-help">{{ __('settings.account.2fa.social') }}</p>
            </div>
        @elseif(empty($user->passwordSecurity) && (auth()->user()->isPatron() || auth()->user()->subscription('kanka')->cancelled()))
            <div class="box-body">
                <p class="help-block">{{ __('settings.account.2fa.helper') }}</p>
                <p>{!! __('settings.account.2fa.enable_instructions', [
                    'android' => link_to('https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2', 'Android', ['target' => '_blank']),
                    'ios' => link_to('https://apps.apple.com/us/app/google-authenticator/id388497605', 'iOS', ['target' => '_blank']),
                ]) !!}</p>
            </div>
            {!! Form::open(['route' => 'settings.security.generate-2fa', 'method' => 'POST']) !!}
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-primary" name="button">{{ __('settings.account.2fa.generate_qr') }}</button>
                </div>
            {!! Form::close() !!}
        @elseif(!$user->passwordSecurity->google2fa_enable && auth()->user()->isPatron() || auth()->user()->subscription('kanka')->cancelled())
            {!! Form::open(['route' => 'settings.security.enable-2fa', 'method' => 'POST']) !!}
            <div class="box-body">
                <p class="help-block">{{ __('settings.account.2fa.activation_helper') }}</p>

                <div class="form-group required">
                    <label>{{ __('settings.account.2fa.fields.qrcode') }}</label><br />
                    {!! $user->passwordSecurity->getGoogleQR() !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('settings.account.2fa.fields.otp') }}</label>
                    {!! Form::text('otp', null, ['class' => 'form-control', 'maxlength' => 8]) !!}
                </div>
            </div>
            <div class="box-footer text-right">
                <button type="submit" class="btn btn-primary" name="button">{{ __('settings.account.2fa.enable') }}</button>
            </div>
            {!! Form::close() !!}
       @endif
  @endif
</div>

@section('modals')
    @parent
    @if($user->passwordSecurity?->google2fa_enable))
        <div class="modal fade" id="deactivate-2fa" tabindex="-1" role="dialog" aria-labelledby="deactivate2FALabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-2xl">
                    <div class="modal-body text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                        <h4>
                            {{ __('profiles.sections.delete.title') }}
                        </h4>

                        <p class="mt-3">
                            {{ __('settings.account.2fa.disable_helper') }}                    </p>
                        <div class="py-5">
                            {!! Form::model($user, ['method' => 'POST', 'route' => ['settings.security.disable-2fa']]) !!}
                            <button type="submit" class="btn btn-danger rounded-full px-8">
                                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ __('settings.account.2fa.disable_confirm') }}
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
