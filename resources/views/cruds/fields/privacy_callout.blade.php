
<div class="privacy-callout my-4 px-5 py-4">
    <div class="mb-3">
        <i class="fa-solid fa-lock mr-1" aria-hidden="true"></i>
        <label>{{ __('crud.fields.privacy') }}</label>
    </div>
    <div class="my-1 checkbox">
        {!! Form::hidden('is_private', 0) !!}
        <label>
            {!! Form::checkbox('is_private', 1, empty($model) ? (!empty($source) ? $source->is_private : CampaignLocalization::getCampaign()->entity_visibility) : $model->is_private) !!}
            {!! __('crud.fields.is_private_v3', [
    'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get(\App\Facades\CampaignCache::adminRole(), 'name', __('campaigns.roles.admin_role')), null, ['target' => '_blank'])
]) !!}
        </label>
    </div>
</div>
