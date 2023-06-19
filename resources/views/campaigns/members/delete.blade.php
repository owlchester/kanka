<?php /**
 * @var \App\Models\CampaignUser $campaignUser
 */
?>
<x-dialog.header>
    {!! __('crud.delete_modal.title') !!}
</x-dialog.header>
<article class="text-left max-w-2xl">
    @include('partials.errors')

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['campaign_users.destroy', $campaignUser->id],
         'class' => 'w-full'
     ]) !!}

    <p class="mt-3">
        {!! __('campaigns.members.removal', ['member' => '<strong>' . $campaignUser->user->name. '</strong>']) !!}<br />
        <span class="permanent">
            {{ __('crud.delete_modal.permanent') }}
        </span>
    </p>

    <x-dialog.footer>
        <button type="submit" class="btn2 btn-error btn-outline">
            <span class="fa-solid fa-trash" aria-hidden="true"></span>
            <span class="remove-button-label">{{ __('crud.remove') }}</span>
        </button>
    </x-dialog.footer>
    {!! Form::close() !!}
</article>

