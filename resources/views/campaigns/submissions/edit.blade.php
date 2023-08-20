<x-dialog.header>
    @if($action === 'approve')
        {{ __('campaigns/submissions.actions.accept') }}
    @else
        {{ __('campaigns/submissions.actions.reject') }}
    @endif
</x-dialog.header>
<article>
    {!! Form::model($submission, ['method' => 'PATCH', 'route' => ['campaign_submissions.update', $campaign, $submission->id], 'data-shortcut' => 1, 'class' => 'entity-form w-full max-w-lg text-left']) !!}
        @if($action === 'approve')
            <p>{{ __('campaigns/submissions.update.approve') }}</p>

            <x-grid type="1/1">
                <div class="field-role text-left">
                    <label>{{ __('campaigns.members.fields.role') }}</label>
                    {!! Form::select('role_id', $campaign->roles()->where('is_public', false)->orderBy('is_admin')->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="field-approval text-left">
                    <label>{{ __('campaigns/submissions.fields.approval') }}</label>
                    {!! Form::text('message', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </x-grid>
            <x-buttons.confirm type="primary" full="true">
                <x-icon class="check" />
                {{ __('campaigns/submissions.actions.accept') }}
            </x-buttons.confirm>
        @else
            <p>{{ __('campaigns/submissions.update.reject') }}</p>
            <div class="field-rejection mb-5">
                <label>{{ __('campaigns/submissions.fields.rejection') }}</label>
                {!! Form::text('rejection', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
            </div>

            <x-buttons.confirm type="danger" full="true">
                <i class="fa-solid fa-times" aria-hidden="true"></i>
                {{ __('campaigns/submissions.actions.reject') }}
            </x-buttons.confirm>
        @endif

    <input type="hidden" name="action" value="{{ $action }}" />
    {!! Form::close() !!}
</article>

