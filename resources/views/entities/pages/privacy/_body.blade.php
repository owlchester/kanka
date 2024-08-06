<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignRole $role
 * @var \App\User $user
 * */?>
<x-grid type="1/1">
    <x-forms.field field="visibility" :label="__('entities/permissions.quick.field')">
        <select name="privacy" id="quick-privacy-select" class="" data-url="{{ route('entities.quick-privacy.toggle', [$campaign, $entity]) }}">
            <option value="0">{{ __('entities/permissions.quick.options.visible') }}</option>
            <option value="1" @if ($entity->is_private) selected="selected" @endif>{{ __('entities/permissions.quick.options.private') }}</option>
        </select>
    </x-forms.field>

    <hr class="m-0" />

    <p class="font-extrabold m-0">
        {{ __('entities/permissions.quick.viewable-by') }}
    </p>
    @if (!empty($visibility['roles']) || !empty($visibility['users']))
        <div class="@if ($entity->is_private) line-through text-slate-400 @endif flex flex-wrap gap-2 items-center ">
            @foreach ($visibility['roles'] as $role)
                <span>
                    <x-icon class="fa-solid fa-user-group" />
                    {!! $role->name !!}
                    @if ($role->isPublic() && !$campaign->isPublic())
                        <x-icon class="fa-solid fa-exclamation-triangle text-accent" tooltip :title="__('campaigns.roles.permissions.helpers.not_public')" />
                    @endif
                </span>
            @endforeach
            @foreach ($visibility['users'] as $user)
                <div class="flex gap-1 items-center">
                    @if ($user->hasAvatar())
                        <div class="avatar cover-background w-4 h-4 rounded-full" style="background-image: url('{!! $user->getAvatarUrl() !!}')"></div>
                    @else
                        <x-icon class="fa-solid fa-user" />
                    @endif
                    {!! $user->name !!}
                </div>
            @endforeach
        </div>
    @else
        <p class="text-neutral-content m-0">
            {{ __('entities/permissions.quick.empty-permissions') }}
        </p>
    @endif
</x-grid>
