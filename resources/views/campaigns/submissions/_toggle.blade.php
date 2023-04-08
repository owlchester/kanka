<x-dialog.header>
    {{ __('campaigns/submissions.actions.accept') }}
</x-dialog.header>
<article>
    {!! Form::model($campaign, ['route' => 'campaign-applications.save', 'method' => 'POST', 'class' => 'text-left w-full max-w-lg']) !!}

    <div class="form-group required">
        <label for="status">
           {{ __('campaigns/submissions.toggle.label') }}
        </label>
        {!! Form::select('status', [0 => __('campaigns/submissions.toggle.closed'), 1 => __('campaigns/submissions.toggle.open')], $campaign->is_open, ['class' => 'form-control']) !!}
        <p class="help-block">
            {{ __('campaigns/submissions.helpers.modal') }}
        </p>
    </div>

    <div class="grid grid-cols-2 gap-2 mt-5">
        <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
            {{ __('crud.cancel') }}
        </x-buttons.confirm>
        <x-buttons.confirm type="primary" outline="true" full="true">
            <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i>
            {{ __('crud.actions.apply') }}
        </x-buttons.confirm>

    </div>
    {!! Form::close() !!}
</article>
