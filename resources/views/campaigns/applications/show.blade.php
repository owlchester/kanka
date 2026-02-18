<?php /** @var \App\Models\Application $application */ ?>
<x-dialog.header>

</x-dialog.header>
<x-dialog.article>
    <x-form :action="['applications.update', $campaign, $application->id]" method="PATCH" class="entity-form w-full max-w-lg text-left" direct>

        @include('campaigns.applications._view')
            <x-forms.field
                field="reason"
                :label="__('campaigns/applications.fields.reason')"
                :helper="__('campaigns/applications.helpers.reason')">

                <input type="text" name="reason" value="{{ old('reason') }}" maxlength="191" class="w-full"  autocomplete="off" placeholder="{{ __('campaigns/applications.placeholders.reason') }}" />
            </x-forms.field>

            <x-forms.field
                field="role"
                :label="__('campaigns.members.fields.role')"
                :helper="__('campaigns/applications.helpers.role')">
                <x-forms.select name="role_id" :options="$campaign->roles()->where('is_public', false)->orderBy('is_admin')->pluck('name', 'id')" class="w-full" />
            </x-forms.field>

            <div class="flex items-center justify-between gap-4 mb-5">
                <button type="submit" class="btn2 btn-error btn-outline" name="action" value="reject">
                    <x-icon class="fa-regular fa-times" />
                    {{ __('campaigns/applications.actions.reject') }}
                </button>

                <button type="submit" class="btn2 btn-primary" name="action" value="accept">
                    <x-icon class="check" />
                    {{ __('campaigns/applications.actions.accept') }}
                </button>
            </div>
    </x-form>
</x-dialog.article>

