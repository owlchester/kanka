<x-dialog.header>
    {{ __('campaigns/submissions.actions.accept') }}
</x-dialog.header>
<article>
    {!! Form::model($campaign, ['route' => 'campaign-applications.save', 'method' => 'POST', 'class' => 'text-left w-full max-w-lg']) !!}

    <div class="field-status required">
        <label for="status">
           {{ __('campaigns/submissions.toggle.label') }}
        </label>
        {!! Form::select('status', [0 => __('campaigns/submissions.toggle.closed'), 1 => __('campaigns/submissions.toggle.open')], $campaign->is_open, ['class' => 'form-control']) !!}
        <p class="help-block">
            {{ __('campaigns/submissions.helpers.modal') }}
        </p>
    </div>

    <x-dialog.footer>
        <x-buttons.confirm type="primary">
            <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i>
            {{ __('crud.actions.apply') }}
        </x-buttons.confirm>
    </x-dialog.footer>
    {!! Form::close() !!}
</article>
