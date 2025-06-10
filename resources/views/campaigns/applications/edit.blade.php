<x-dialog.header>
    @if($action === 'approve')
        {{ __('campaigns/applications.actions.accept') }}
    @else
        {{ __('campaigns/applications.actions.reject') }}
    @endif
</x-dialog.header>
<x-dialog.article>
    <x-form :action="['applications.update', $campaign, $application->id]" method="PATCH" class="entity-form w-full max-w-lg text-left">
        @if($action === 'approve')

            <x-grid type="1/1">
                <p class="m-0">{{ __('campaigns/applications.update.approve') }}</p>

                <x-forms.field
                    field="role"
                    :label="__('campaigns.members.fields.role')"
                    required>
                    <x-forms.select name="role_id" :options="$campaign->roles()->where('is_public', false)->orderBy('is_admin')->pluck('name', 'id')" class="w-full" />
                </x-forms.field>

                <x-forms.field
                    field="message"
                    :label="__('campaigns/applications.fields.approval')">
                    <input type="text" name="message" value="{!! old('message') !!}" maxlength="191" class="w-full" />
                </x-forms.field>

                <x-buttons.confirm type="primary" full="true">
                    <x-icon class="check" />
                    {{ __('campaigns/applications.actions.accept') }}
                </x-buttons.confirm>
            </x-grid>
        @else
        <x-grid type="1/1">
            <p class="m-0">{{ __('campaigns/applications.update.reject') }}</p>

            <x-forms.field
                field="message"
                :label="__('campaigns/applications.fields.rejection')">

                <input type="text" name="rejection" value="{!! old('rejection') !!}" maxlength="191" class="w-full" />
            </x-forms.field>

            <x-buttons.confirm type="danger" full="true">
                <x-icon class="fa-solid fa-times" />
                {{ __('campaigns/applications.actions.reject') }}
            </x-buttons.confirm>
        </x-grid>
        @endif

    <input type="hidden" name="action" value="{{ $action }}" />
    </x-form>
</x-dialog.article>

