@if (auth()->user()->isAdmin())
    <hr />
    <h4 class="">{{ __('crud.fields.privacy') }}</h4>
    <div class="checkbox">
        {!! Form::hidden('is_private', 0) !!}
        <label>
            {!! Form::checkbox('is_private', 1, empty($model) ? (!empty($source) ? $source->is_private : CampaignLocalization::getCampaign()->entity_visibility) : $model->is_private) !!}
            {!! __('crud.fields.is_private_v2', [
    'admin-role' => link_to_route('campaigns.campaign_roles.admin', __('campaigns.roles.admin_role'), $campaign->campaign()->id)
]) !!}
        </label>
    </div>
@endif
