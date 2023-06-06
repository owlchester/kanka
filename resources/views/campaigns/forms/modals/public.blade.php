{!! Form::model($campaign, ['route' => 'campaign-visibility.save', 'method' => 'POST']) !!}

<div class="modal-body">
    <x-dialog.close />
    <h4 class="modal-title  text-center mb-5">
        {!! __('campaigns/public.title') !!}
    </h4>

    <x-alert type="info">
        <p>{!! __('campaigns/public.helpers.main', [
    'public-campaigns' => link_to_route('front.public_campaigns', __('front.menu.campaigns'), null, ['target' => '_blank']),
    'public-role' => link_to_route('campaigns.campaign_roles.public', __('campaigns.members.roles.public'), null, ['target' => '_blank'])
]) !!}</p>
        <p>
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
        </p>
    </x-alert>


    <div class="form-group">
        <label>
            {{ __('campaigns.fields.public') }}
        </label>
        {!! Form::select('is_public', [0 => __('campaigns.visibilities.private'), 1 => __('campaigns.visibilities.public')], null, ['class' => 'form-control']) !!}
    </div>

    <x-dialog.footer>
        <button class="btn2 btn-primary">{{ __('crud.actions.apply') }}</button>
    </x-dialog.footer>
</div>
@if (isset($from) && $from === 'overview')
    <input type="hidden" name="from" value="{{ $from }}" />
@endif
{!! Form::close() !!}
