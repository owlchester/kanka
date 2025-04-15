<?php /** @var \App\Models\CampaignSubmission $application */ ?>
<x-dialog.header>

</x-dialog.header>
<x-dialog.article>
    <x-form :action="['campaign_submissions.update', $campaign, $application->id]" method="PATCH" class="entity-form w-full max-w-lg text-left" direct>

        <div class="flex flex-col gap-4">
            @if ($application->user->hasAvatar())
                <x-users.avatar :user="$application->user" class="h-14 w-14" size="80" />
            @endif

            <div class="flex items-end gap-5">
                <span class="text-xl">{!! $application->user->name !!}</span>
                <span class="text-neutral-content" title="{{ $application->created_at }}">
                    {{ $application->created_at->diffForHumans() }}
                </span>
            </div>

            <p class="text-neutral-content">{!! $application->text !!}</p>

            <x-forms.field
                field="reason"
                :label="__('campaigns/submissions.fields.reason')"
                :helper="__('campaigns/submissions.helpers.reason')">

                <input type="text" name="reason" value="{{ old('reason') }}" maxlength="191" class="w-full"  autocomplete="off" placeholder="{{ __('campaigns/submissions.placeholders.reason') }}" />
            </x-forms.field>

            <x-forms.field
                field="role"
                :label="__('campaigns.members.fields.role')"
                :helper="__('campaigns/submissions.helpers.role')">
                <x-forms.select name="role_id" :options="$campaign->roles()->where('is_public', false)->orderBy('is_admin')->pluck('name', 'id')" class="w-full" />
            </x-forms.field>

            <div class="flex items-center justify-between gap-4 mb-5">
                <button type="submit" class="btn2 btn-error btn-outline" name="action" value="reject">
                    <x-icon class="fa-regular fa-times" />
                    {{ __('campaigns/submissions.actions.reject') }}
                </button>

                <button type="submit" class="btn2 btn-primary" name="action" value="accept">
                    <x-icon class="check" />
                    {{ __('campaigns/submissions.actions.accept') }}
                </button>
            </div>
        </div>

    </x-form>
</x-dialog.article>

