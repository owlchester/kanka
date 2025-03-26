<x-grid type="1/1">
    <x-helper>
        <p>{!! __('campaigns/public.helpers.main', [
        'public-campaigns' => '<a href="https://kanka.io/campaigns" target="_blank">' . __('footer.public-campaigns') . '</a>',
        'public-role' => '<a href="' . route('campaigns.campaign_roles.public', $campaign) . '" target="_blank">' . __('campaigns.members.roles.public') . '</a>',
    ]) !!}</p>
        <p>
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
        </p>
    </x-helper>

    <x-forms.field
        field="public"
        :label="__('campaigns.fields.public')">
        <x-forms.select name="is_public" :options="[0 => __('campaigns.visibilities.private'), 1 => __('campaigns.visibilities.public')]" :selected="$campaign->is_public ?? null" />
    </x-forms.field>
</x-grid>
