<x-dialog.header>
    @if($action === 'approve')
        {{ __('campaigns/submissions.actions.accept') }}
    @else
        {{ __('campaigns/submissions.actions.reject') }}
    @endif
</x-dialog.header>
<article>
    <x-form :action="['campaign_submissions.update', $campaign, $submission->id]" method="PATCH" class="entity-form w-full max-w-lg text-left">
        @if($action === 'approve')

            <x-grid type="1/1">
                <p class="m-0">{{ __('campaigns/submissions.update.approve') }}</p>

                <x-forms.field
                    field="role"
                    :label="__('campaigns.members.fields.role')"
                    :required="true">
                    <x-forms.select name="role_id" :options="$campaign->roles()->where('is_public', false)->orderBy('is_admin')->pluck('name', 'id')" class="w-full" />
                </x-forms.field>

                <x-forms.field
                    field="message"
                    :label="__('campaigns/submissions.fields.approval')">
                    <input type="text" name="message" value="{!! old('message') !!}" maxlength="191" class="w-full" />
                </x-forms.field>

                <x-buttons.confirm type="primary" full="true">
                    <x-icon class="check" />
                    {{ __('campaigns/submissions.actions.accept') }}
                </x-buttons.confirm>
            </x-grid>
        @else
        <x-grid type="1/1">
            <p class="m-0">{{ __('campaigns/submissions.update.reject') }}</p>

            <x-forms.field
                field="message"
                :label="__('campaigns/submissions.fields.rejection')">

                <input type="text" name="rejection" value="{!! old('rejection') !!}" maxlength="191" class="w-full" />
            </x-forms.field>

            <x-buttons.confirm type="danger" full="true">
                <x-icon class="fa-solid fa-times" />
                {{ __('campaigns/submissions.actions.reject') }}
            </x-buttons.confirm>
        </x-grid>
        @endif

    <input type="hidden" name="action" value="{{ $action }}" />
    </x-form>
</article>

