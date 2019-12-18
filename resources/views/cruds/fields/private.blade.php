@if (Auth::user()->isAdmin())
    <hr />
    <div class="form-group">
        {!! Form::hidden('is_private', 0) !!}
        <label>{!! Form::checkbox('is_private', 1, empty($model) ? (!empty($source) ? $source->is_private : CampaignLocalization::getCampaign()->entity_visibility) : $model->is_private) !!}
            {{ __('crud.fields.is_private') }}
        </label>
        <p class="help-block">{{ __('crud.hints.is_private') }}</p>
    </div>
@endif