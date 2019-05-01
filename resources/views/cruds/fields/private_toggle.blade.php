@if (Auth::user()->isAdmin())
    <div class="form-group">
        <label>
            {{ trans('crud.fields.is_private') }}
        </label>
        <div class="pull-right">
            {!! Form::checkbox('is_private', 'checked', empty($model) ? CampaignLocalization::getCampaign()->entity_visibility : $model->is_private, [
                'data-toggle' => 'switch', 'data-on-text' => __('crud.fields.is_private')
            ]) !!}
        </div>
        <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
    </div>
@endif