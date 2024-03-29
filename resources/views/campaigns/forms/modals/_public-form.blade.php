<x-grid type="1/1">
    <x-alert type="info">
        <p>{!! __('campaigns/public.helpers.main', [
        'public-campaigns' => link_to('https://kanka.io/campaigns', __('footer.public-campaigns'), null, ['target' => '_blank']),
        'public-role' => link_to_route('campaigns.campaign_roles.public', __('campaigns.members.roles.public'), $campaign, ['target' => '_blank'])
    ]) !!}</p>
        <p>
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
        </p>
    </x-alert>

    <x-forms.field
        field="public"
        :label="__('campaigns.fields.public')">
        {!! Form::select('is_public', [0 => __('campaigns.visibilities.private'), 1 => __('campaigns.visibilities.public')], null, ['class' => 'w-full']) !!}
    </x-forms.field>
</x-grid>
