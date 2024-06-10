@php
$data = [];
if (isset($privacyToggle)) {
    $data['data-toggle'] = 'entity-privacy';
}
@endphp
<div class="privacy-callout border-l-2 border-orange-200 p-3 flex flex-col gap-1">
    <div class="flex gap-2">
        <x-icon class="fa-solid fa-lock" />
        <label class="grow">{{ __('crud.fields.privacy') }}</label>
    </div>
    <div class="">
        <input type="hidden" name="is_private" value="0" />
        <x-checkbox :text="__('crud.fields.is_private_v3', [
        'admin-role' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\' target=\'_blank\'>' . \Illuminate\Support\Arr::get(\App\Facades\CampaignCache::adminRole(), 'name', __('campaigns.roles.admin_role')) . '</a>'
])">

            <input type="checkbox" name="is_private" value="1" @if (old('is_private', $source->is_private ?? $model->is_private ?? $campaign->entity_visibility)) checked="checked" @endif data-toggle="entity-privacy" />
        </x-checkbox>
    </div>
</div>
