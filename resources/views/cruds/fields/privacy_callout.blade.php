@php
$data = [];
if (isset($privacyToggle)) {
    $data['data-toggle'] = 'entity-privacy';
}
$isPrivate = old('is_private', $source->is_private ?? $model->is_private ?? $campaign->entity_visibility)
@endphp
<div class="privacy-callout rounded-xl p-4 border border-red-300">
    <input type="hidden" name="is_private" value="0" />
    <label class="flex items-start gap-2 cursor-pointer">
        <input type="checkbox" name="is_private" value="1" @if ($isPrivate) checked="checked" @endif data-toggle="entity-privacy" class="" />

        <div>
            <p class="font-semibold ">
                {{ __('crud.permissions.actions.private') }}
            </p>
            <x-helper>
                {!! __('crud.fields.is_private_v3', [
        'admin-role' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\'>' . \Illuminate\Support\Arr::get(\App\Facades\CampaignCache::adminRole(), 'name', __('campaigns.roles.admin_role')) . '</a>'
        ]) !!}
                <a
                    href="https://docs.kanka.io/en/latest/features/permissions.html#entity-permissions"
                    data-toggle="tooltip"
                    data-title="{{ __('general.documentation') }}">
                    <x-icon class="fa-regular fa-book" />
                    {{ __('general.learn-more') }}
                </a>.
            </x-helper>
        </div>
    </label>
</div>
