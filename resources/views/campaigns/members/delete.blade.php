<?php /**
 * @var \App\Models\CampaignUser $campaignUser
 */
?>
<x-dialog.header>
    {!! __('crud.delete_modal.title') !!}
</x-dialog.header>
<article class="text-left max-w-2xl p-4 md:px-6">
    @include('partials.errors')

    <x-form method="DELETE" :action="['campaign_users.destroy', $campaign, $campaignUser->id]">

    <p class="">
        {!! __('campaigns.members.removal', ['member' => '<strong>' . $campaignUser->user->name. '</strong>']) !!}<br />
        <span class="permanent">
            {{ __('crud.delete_modal.permanent') }}
        </span>
    </p>

    <x-dialog.footer>
        <button type="submit" class="btn2 btn-error btn-outline">
            <x-icon class="fa-solid fa-trash-can" />
            <span class="remove-button-label">{{ __('crud.remove') }}</span>
        </button>
    </x-dialog.footer>
    </x-form>
</article>

