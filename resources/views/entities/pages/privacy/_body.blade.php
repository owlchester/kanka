<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\User $user
 * */?>
<div
    class="w-full"
    x-data="{ private: {{ $entity->is_private ? 1 : 0 }}, saving: false, status: '' }"
    x-init="$watch('private', value => {
    if (saving) return;
    saving = true;
    status = '';
    axios.post('{{ route('entities.quick-privacy.toggle', [$campaign, $entity]) }}', {
                is_private: value
            })
            .then(response => {
                saving = false;
                status = response.data.status;
            })
            .catch(error => {
                statusLabel = '';
                status = '';
                saving = false;
            });
    })">

    <x-grid type="1/1">
        <x-forms.field field="visibility" :label="__('entities/permissions.toggle.label')">
            <div class="flex flex-col gap-2">
                <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                    <input type="radio" name="is_private" id="visibility-private" value="1" class="mt-1" @if ($entity->is_private) checked="checked" @endif" x-model="private">
                    <div class="flex flex-col gap-0 grow">
                        <label for="visibility-private" class="w-full cursor-pointer">
                            {{ __('entities/permissions.toggle.private.title') }}
                            <p class="text-xs text-neutral-content">
                                {{ __('entities/permissions.toggle.private.description', ['admin' => $campaign->adminRoleName()]) }}
                            </p>
                        </label>
                    </div>
                    <i class="fa-solid fa-spinner fa-spin text-neutral-content" x-show="saving && private === '1'" x-cloak aria-label="Saving..."></i>
                    <i class="fa-regular fa-check-double text-success" x-show="status === true" x-cloak aria-label="Saved" data-title="{{ __('entities/permissions.quick.success.private', ['entity' => $entity->name]) }}" data-toggle="tooltip"></i>
                </div>
                <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                    <input type="radio" name="is_private" id="visibility-public" value="0" class="mt-1" @if (!$entity->is_private) checked="checked" @endif" x-model="private">
                    <div class="flex flex-col gap-0 grow">
                        <label for="visibility-public" class="w-full cursor-pointer">
                            {{ __('entities/permissions.toggle.public.title') }}
                            <p class="text-xs text-neutral-content">
                                {{ __('entities/permissions.toggle.public.description') }}
                            </p>
                        </label>
                    </div>
                    <i class="fa-solid fa-spinner fa-spin text-neutral-content" x-show="saving && private === '0'" x-cloak aria-label="Saving..."></i>
                    <i class="fa-regular fa-check-double text-success" x-show="status === false" x-cloak aria-label="Saved" data-title="{{ __('entities/permissions.quick.success.public', ['entity' => $entity->name]) }}" data-toggle="tooltip"></i>
                </div>
            </div>
        </x-forms.field>

        <hr />

        <div class="flex flex-col gap-1">

        <p class="">
            {{ __('entities/permissions.quick.viewable-by') }}
        </p>
        @if (!empty($visibility['roles']) || !empty($visibility['users']))
            <div class="flex flex-wrap gap-2 items-center " :class="{ 'line-through text-neutral-content': private === '1'}">
                @foreach ($visibility['roles'] as $role)
                    <span>
                        <x-icon class="fa-regular fa-user-group" />
                        @can('update', $role)
                            <a href="{{ route('campaign_roles.edit', [$campaign, $role]) }}" class="text-link">
                                {!! $role->name !!}
                            </a>
                        @else
                            {!! $role->name !!}
                        @endif
                        @if ($role->isPublic() && $campaign->isPrivate())
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
</div>
