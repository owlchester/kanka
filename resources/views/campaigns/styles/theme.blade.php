{!! Form::model($campaign, ['route' => 'campaign-theme.save', 'method' => 'POST']) !!}

<div class="modal-body">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title  text-center mb-5">
        {!! __('campaigns/styles.theme.title') !!}
    </h4>

    <div class="form-group">
        <label>
            {{ __('campaigns.fields.theme') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('campaigns.helpers.theme') }}"></i>
        </label>

        {!! Form::select(
            'theme_id',
            $themes,
            null,
            ['class' => 'form-control']
        ) !!}
        <p class="help-block visible-xs visible-sm">{{ __('campaigns.helpers.theme') }}</p>
    </div>

    <div class="my-5 text-center">
        <button type="button" class="btn btn-default mr-5 rounded-full px-8" data-dismiss="modal">
            {{ __('crud.cancel') }}
        </button>

        <button class="btn btn-success ml-5 rounded-full px-8">{{ __('crud.actions.apply') }}</button>

    </div>
</div>
{!! Form::close() !!}
