{!! Form::model($campaign, ['route' => 'campaign-theme.save', 'method' => 'POST']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">
        {!! __('campaigns/styles.theme.title') !!}
    </h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>
            {{ __('campaigns.fields.theme') }}
            <i class="fas fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('campaigns.helpers.theme') }}"></i>
        </label>

        {!! Form::select(
            'theme_id',
            $themes,
            null,
            ['class' => 'form-control']
        ) !!}
        <p class="help-block visible-xs visible-sm">{{ __('campaigns.helpers.theme') }}</p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
        {{ __('crud.cancel') }}
    </button>

    <button class="btn btn-success">{{ __('crud.actions.apply') }}</button>
</div>
{!! Form::close() !!}
