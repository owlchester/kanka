@php
$data = [];
if (isset($privacyToggle)) {
    $data['data-toggle'] = 'entity-privacy';
}
@endphp
<div class="privacy-callout border-l-2 border-orange-200 px-3 py-1 mb-1">
    <div class="my-1">
        <i class="fa-solid fa-lock mr-1" aria-hidden="true"></i>
        <label class="">{{ __('crud.fields.privacy') }}</label>
    </div>
    <div class="my-1 checkbox">
        {!! Form::hidden('is_private', 0) !!}
        <label class="m-0 select-none">
            {!! Form::checkbox('is_private', 1, empty($model) ? (!empty($source) ? $source->is_private : CampaignLocalization::getCampaign()->entity_visibility) : $model->is_private, $data) !!}
            {!! __('crud.fields.is_private_v3', [
    'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get(\App\Facades\CampaignCache::adminRole(), 'name', __('campaigns.roles.admin_role')), null, ['target' => '_blank'])
]) !!}
        </label>
    </div>
</div>
