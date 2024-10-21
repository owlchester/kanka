<div class="formless">
    <x-dialog.header>
        {{ __('campaigns.members.manage_roles') }} - {!! $campaignUser->user->name !!}
    </x-dialog.header>
    <article class="max-w-2xl">
        @include('campaigns.members._form')
    </article>
</div>
