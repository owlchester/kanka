<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\User $user
 * */?>
<x-grid type="1/1">
    <x-forms.field field="visibility" :label="__('entities/permissions.quick.field')">
        <select name="privacy" id="quick-privacy-select" class="" data-url="{{ route('entities.quick-privacy.toggle', [$campaign, $entity]) }}">
            <option value="0">{{ __('entities/permissions.quick.options.visible') }}</option>
            <option value="1" @if ($entity->is_private) selected="selected" @endif>{{ __('entities/permissions.quick.options.private') }}</option>
        </select>
    </x-forms.field>

    <hr />

    <div class="flex flex-col gap-1">
    <p class="">
        {{ __('entities/permissions.quick.viewable-by') }}
    </p>
    @if (!empty($visibility['roles']) || !empty($visibility['users']))
        <div class="@if ($entity->is_private) line-through text-slate-400 @endif flex flex-wrap gap-2 items-center ">
            @foreach ($visibility['roles'] as $role)
                <span>
                    <x-icon class="fa-regular fa-user-group" />
                    @can('update', $role)
                        <a href="{{ route('campaign_roles.edit', [$campaign, $role]) }}">
                            {!! $role->name !!}
                        </a>
                    @else
                        {!! $role->name !!}
                    @endif
                    @if ($role->isPublic() && !$campaign->isPublic())
                        <x-icon class="fa-regular fa-exclamation-triangle text-accent" tooltip :title="__('campaigns.roles.permissions.helpers.not_public')" />
                    @endif
                </span>
            @endforeach
            @foreach ($visibility['users'] as $user)
                <div class="flex gap-1 items-center">
                    @if ($user->hasAvatar())
                        <x-users.avatar :user="$user" class="w-5 h-5" />
                    @else
                        <x-icon class="fa-regular fa-user" />
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
    </div>
</x-grid>
