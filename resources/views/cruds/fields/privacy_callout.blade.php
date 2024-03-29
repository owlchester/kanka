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
        {!! Form::hidden('is_private', 0) !!}
        <x-checkbox :text="__('crud.fields.is_private_v3', [
    'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get(\App\Facades\CampaignCache::adminRole(), 'name', __('campaigns.roles.admin_role')), [$campaign], ['target' => '_blank'])
])">
            {!! Form::checkbox('is_private', 1, empty($model) ? (!empty($source) ? $source->is_private : $campaign->entity_visibility) : $model->is_private, $data) !!}
        </x-checkbox>
    </div>
</div>
