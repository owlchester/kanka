{!! Form::model($campaign, ['route' => 'campaign-theme.save', 'method' => 'POST']) !!}

<div class="modal-body">
    <x-dialog.close />
    <h4 class="modal-title  text-center mb-5">
        {!! __('campaigns/styles.theme.title') !!}
    </h4>

    <div class="field-theme">
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

    <x-dialog.footer>
        <button class="btn2 btn-primary">{{ __('crud.actions.apply') }}</button>
    </x-dialog.footer>
</div>
{!! Form::close() !!}
