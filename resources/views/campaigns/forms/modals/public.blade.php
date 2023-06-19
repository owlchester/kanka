<x-dialog.header>
    {!! __('campaigns/public.title') !!}
</x-dialog.header>
<article class="text-left max-w-2xl">

{!! Form::model($campaign, ['route' => 'campaign-visibility.save', 'method' => 'POST']) !!}

    <x-alert type="info">
        <p>{!! __('campaigns/public.helpers.main', [
    'public-campaigns' => link_to_route('front.public_campaigns', __('front.menu.campaigns'), null, ['target' => '_blank']),
    'public-role' => link_to_route('campaigns.campaign_roles.public', __('campaigns.members.roles.public'), null, ['target' => '_blank'])
]) !!}</p>
        <p>
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
        </p>
    </x-alert>


    <div class="field-public">
        <label>
            {{ __('campaigns.fields.public') }}
        </label>
        {!! Form::select('is_public', [0 => __('campaigns.visibilities.private'), 1 => __('campaigns.visibilities.public')], null, ['class' => 'form-control']) !!}
    </div>

    <x-dialog.footer>
        <button class="btn2 btn-primary">{{ __('crud.actions.apply') }}</button>
    </x-dialog.footer>
@if (isset($from) && $from === 'overview')
    <input type="hidden" name="from" value="{{ $from }}" />
@endif
{!! Form::close() !!}
</article>
