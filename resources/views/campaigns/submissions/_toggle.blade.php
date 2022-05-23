{!! Form::model($campaign, ['route' => 'campaign-applications.save', 'method' => 'POST']) !!}


<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title mb-5" id="myModalLabel">
        {{ __('campaigns/submissions.toggle.title') }}
    </h4>

    <div class="form-group required">
        <label for="status">
           {{ __('campaigns/submissions.toggle.label') }}
        </label>
        {!! Form::select('status', [0 => __('campaigns/submissions.toggle.closed'), 1 => __('campaigns/submissions.toggle.open')], $campaign->is_open, ['class' => 'form-control']) !!}
        <p class="help-block">
            {{ __('campaigns/submissions.helpers.modal') }}
        </p>
    </div>

    <div class="text-center py-5">
        <button type="button" class="btn btn-default mr-5 rounded-full px-8" data-dismiss="modal">
            {{ __('crud.cancel') }}
        </button>

        <button class="btn btn-success ml-5 rounded-full px-8">{{ __('crud.actions.apply') }}</button>

    </div>
</div>
{!! Form::close() !!}
