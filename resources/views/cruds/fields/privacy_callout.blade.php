@php
$data = [];
if (isset($privacyToggle)) {
    $data['data-toggle'] = 'entity-privacy';
}
@endphp
<div class="privacy-callout border-l-2 border-orange-200 p-3 mb-2 flex flex-col gap-1">
    <div class="flex gap-2">
        <i class="fa-solid fa-lock" aria-hidden="true"></i>
        <label class="grow m-0">{{ __('crud.fields.privacy') }}</label>
    </div>
    <div class="m-0 checkbox">
        {!! Form::hidden('is_private', 0) !!}
        <label class="m-0 select-none">
            {!! Form::checkbox('is_private', 1, empty($model) ? (!empty($source) ? $source->is_private : $campaign->entity_visibility) : $model->is_private, $data) !!}
            {!! __('crud.fields.is_private_v3', [
    'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get(\App\Facades\CampaignCache::adminRole(), 'name', __('campaigns.roles.admin_role')), [$campaign], ['target' => '_blank'])
]) !!}
        </label>
    </div>
</div>
