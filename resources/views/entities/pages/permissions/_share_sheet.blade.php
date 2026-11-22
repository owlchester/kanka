@php
    $actionMeta = [
        \App\Enums\Permission::View->value => __('crud.permissions.actions.view'),
        \App\Enums\Permission::Update->value => __('crud.permissions.actions.edit'),
        \App\Enums\Permission::Delete->value => __('crud.permissions.actions.delete'),
        \App\Enums\Permission::Posts->value => __('entities.articles'),
    ];
@endphp

<div
    class="w-full flex flex-col gap-5"
    x-data="{
        isPrivate: {{ \Illuminate\Support\Js::from((bool) $entity->is_private) }},
        savingPrivacy: false,
        privacyStatus: '',
        canEdit: {{ \Illuminate\Support\Js::from((bool) $canEditPermissions) }},
        showAdvanced: false,
        memberSearch: '',
        roles: {{ \Illuminate\Support\Js::from($rolesData) }},
        membersCatalog: {{ \Illuminate\Support\Js::from($membersCatalog) }},
        get activeMembers() {
            return this.membersCatalog.filter(m => m.has_override);
        },
        get searchResults() {
            const q = this.memberSearch.trim().toLowerCase();
            if (!q) return [];
            return this.membersCatalog
                .filter(m => !m.has_override && m.name.toLowerCase().includes(q))
                .slice(0, 8);
        },
        setPrivacy(value) {
            if (this.savingPrivacy || this.isPrivate === value) return;
            this.savingPrivacy = true;
            this.privacyStatus = '';
            axios.post('{{ route('entities.quick-privacy.toggle', [$campaign, $entity]) }}', {
                is_private: value ? 1 : 0
            }).then(response => {
                this.isPrivate = Boolean(response.data.status);
                this.privacyStatus = this.isPrivate ? 'private' : 'public';
                document.body.classList.toggle('kanka-entity-private', this.isPrivate);
                this.savingPrivacy = false;
            }).catch(() => {
                this.savingPrivacy = false;
            });
        },
        presetFor(item, allowEdit = true) {
            const p = item.perms;
            if (p[1] === 'inherit' && p[2] === 'inherit' && p[4] === 'inherit' && p[5] === 'inherit') return 'inherit';
            if (p[1] === 'deny' && p[2] === 'deny' && p[4] === 'deny' && p[5] === 'deny') return 'deny';
            if (p[1] === 'allow' && p[2] === 'inherit' && p[4] === 'inherit' && p[5] === 'inherit') return 'view';
            if (allowEdit && p[1] === 'allow' && p[2] === 'allow' && p[4] === 'inherit' && p[5] === 'allow') return 'edit';
            return 'custom';
        },
        applyPreset(item, preset, allowEdit = true) {
            if (preset === 'inherit') item.perms = { 1: 'inherit', 2: 'inherit', 4: 'inherit', 5: 'inherit' };
            else if (preset === 'deny') item.perms = { 1: 'deny', 2: 'deny', 4: 'deny', 5: 'deny' };
            else if (preset === 'view') item.perms = { 1: 'allow', 2: 'inherit', 4: 'inherit', 5: 'inherit' };
            else if (preset === 'edit' && allowEdit) item.perms = { 1: 'allow', 2: 'allow', 4: 'inherit', 5: 'allow' };
        },
        addMember(member) {
            member.has_override = true;
            if (this.presetFor(member) === 'inherit') {
                this.applyPreset(member, 'view');
            }
            this.memberSearch = '';
        },
        removeMember(member) {
            member.has_override = false;
            this.applyPreset(member, 'inherit');
        },
        cycleAction(item, actionId) {
            const order = ['inherit', 'allow', 'deny'];
            const idx = order.indexOf(item.perms[actionId]);
            item.perms[actionId] = order[(idx + 1) % order.length];
        },
        actionBadgeClass(val) {
            if (val === 'allow') return 'bg-success text-success-content border-success-content/20';
            if (val === 'deny') return 'bg-error text-error-content border-error-content/20';
            return 'bg-base-200 text-neutral-content border-base-300';
        },
        actionLabel(val) {
            if (val === 'allow') return '{{ __('crud.permissions.actions.bulk_entity.allow') }}';
            if (val === 'deny') return '{{ __('crud.permissions.actions.bulk_entity.deny') }}';
            return '{{ __('crud.permissions.actions.bulk_entity.inherit') }}';
        }
    }"
>
    @if ($canTogglePrivacy)
        <div class="flex flex-col gap-2">
            <label class="text-xs font-semibold uppercase tracking-wider text-neutral-content">
                {{ __('entities/permissions.toggle.label') }}
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <button
                    type="button"
                    @click="setPrivacy(true)"
                    :class="isPrivate ? 'border-primary bg-primary/5' : 'border-base-300 hover:bg-base-200/40'"
                    class="rounded-xl border p-3 flex gap-2.5 items-start text-left cursor-pointer transition-colors"
                >
                    <x-icon class="fa-regular fa-lock mt-0.5 text-sm" />
                    <div class="flex flex-col gap-0.5 grow min-w-0">
                        <span class="font-medium text-sm">{{ __('entities/permissions.toggle.private.title') }}</span>
                        <span class="text-xs text-neutral-content">
                            {{ __('entities/permissions.toggle.private.description', ['admin' => $campaign->adminRoleName()]) }}
                        </span>
                    </div>
                    <i class="fa-solid fa-spinner fa-spin text-neutral-content text-xs mt-1" x-show="savingPrivacy && !isPrivate" x-cloak aria-hidden="true"></i>
                    <i class="fa-regular fa-check text-primary text-sm mt-0.5" x-show="isPrivate" x-cloak aria-hidden="true"></i>
                </button>

                <button
                    type="button"
                    @click="setPrivacy(false)"
                    :class="!isPrivate ? 'border-primary bg-primary/5' : 'border-base-300 hover:bg-base-200/40'"
                    class="rounded-xl border p-3 flex gap-2.5 items-start text-left cursor-pointer transition-colors"
                >
                    <x-icon class="fa-regular fa-lock-open mt-0.5 text-sm" />
                    <div class="flex flex-col gap-0.5 grow min-w-0">
                        <span class="font-medium text-sm">{{ __('entities/permissions.toggle.public.title') }}</span>
                        <span class="text-xs text-neutral-content">
                            {{ __('entities/permissions.toggle.public.description') }}
                        </span>
                    </div>
                    <i class="fa-solid fa-spinner fa-spin text-neutral-content text-xs mt-1" x-show="savingPrivacy && isPrivate" x-cloak aria-hidden="true"></i>
                    <i class="fa-regular fa-check text-primary text-sm mt-0.5" x-show="!isPrivate" x-cloak aria-hidden="true"></i>
                </button>
            </div>
        </div>
    @endif

    @if ($canEditPermissions)
        <div class="flex flex-col gap-5 transition-opacity duration-150" :class="{ 'opacity-60': isPrivate }">
            @if ($canTogglePrivacy)
                <div x-show="isPrivate" x-cloak class="rounded-lg bg-base-200 px-3 py-2 text-xs text-neutral-content flex items-center gap-2">
                    <x-icon class="fa-regular fa-circle-info shrink-0" />
                    <span>{{ __('entities/permissions.share.overridden_private') }}</span>
                </div>
            @endif

            {{-- Roles --}}
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-neutral-content">
                        {{ __('entities/permissions.share.roles_title') }}
                    </span>
                </div>
                <div class="flex flex-col divide-y divide-base-200 rounded-xl border border-base-300">
                    <template x-for="role in roles" :key="role.id">
                        <div class="p-2.5 flex flex-col gap-2">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0 flex flex-col">
                                    <div class="flex items-center gap-1.5 font-medium text-sm truncate">
                                        <template x-if="role.role_url">
                                            <a :href="role.role_url" class="text-link truncate" x-text="role.name"></a>
                                        </template>
                                        <template x-if="!role.role_url">
                                            <span class="truncate" x-text="role.name"></span>
                                        </template>
                                        <template x-if="role.public_warning">
                                            <i class="fa-regular fa-exclamation-triangle text-accent text-xs" data-toggle="tooltip" data-title="{{ __('campaigns.roles.permissions.helpers.not_public') }}" aria-hidden="true"></i>
                                        </template>
                                    </div>
                                    <span class="text-xs text-neutral-content" x-text="role.inherited[1] ? '{{ __('entities/permissions.share.inherited_allow') }}' : '{{ __('entities/permissions.share.inherited_deny') }}'"></span>
                                </div>

                                <select
                                    class="text-sm rounded-lg border border-base-300 bg-base-100 px-2.5 py-1.5 shrink-0"
                                    :value="presetFor(role, !role.is_public)"
                                    @change="applyPreset(role, $event.target.value, !role.is_public)"
                                >
                                    <option value="inherit">{{ __('entities/permissions.share.default') }}</option>
                                    <option value="deny">{{ __('entities/permissions.share.no_access') }}</option>
                                    <option value="view">{{ __('entities/permissions.share.view') }}</option>
                                    <option value="edit" x-show="!role.is_public">{{ __('entities/permissions.share.edit') }}</option>
                                    <option value="custom" x-show="presetFor(role, !role.is_public) === 'custom'">{{ __('entities/permissions.share.custom') }}</option>
                                </select>
                            </div>

                            {{-- Advanced tri-state controls --}}
                            <div x-show="showAdvanced" x-cloak class="flex flex-wrap gap-1.5 pt-1">
                                @foreach ($actionMeta as $actionId => $actionLabel)
                                    @if ($actionId !== \App\Enums\Permission::View->value)
                                        <template x-if="!role.is_public">
                                            <button
                                                type="button"
                                                @click="cycleAction(role, {{ $actionId }})"
                                                :class="actionBadgeClass(role.perms[{{ $actionId }}])"
                                                class="text-xs px-2 py-1 rounded-md border cursor-pointer flex items-center gap-1"
                                            >
                                                <span>{{ $actionLabel }}:</span>
                                                <strong x-text="actionLabel(role.perms[{{ $actionId }}])"></strong>
                                            </button>
                                        </template>
                                    @else
                                        <button
                                            type="button"
                                            @click="cycleAction(role, {{ $actionId }})"
                                            :class="actionBadgeClass(role.perms[{{ $actionId }}])"
                                            class="text-xs px-2 py-1 rounded-md border cursor-pointer flex items-center gap-1"
                                        >
                                            <span>{{ $actionLabel }}:</span>
                                            <strong x-text="actionLabel(role.perms[{{ $actionId }}])"></strong>
                                        </button>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Synced hidden inputs --}}
                            @foreach ($actionMeta as $actionId => $actionLabel)
                                <input type="hidden" :name="`role[${role.id}][{{ $actionId }}]`" :value="role.perms[{{ $actionId }}]" />
                            @endforeach
                        </div>
                    </template>
                </div>
            </div>

            {{-- Members with custom access --}}
            <div class="flex flex-col gap-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-content">
                    {{ __('entities/permissions.share.members_title') }}
                </span>

                <div class="relative">
                    <input
                        type="text"
                        x-model="memberSearch"
                        placeholder="{{ __('entities/permissions.share.add_member') }}"
                        class="w-full text-sm rounded-xl border border-base-300 bg-base-100 px-3 py-2"
                        autocomplete="off"
                    />
                    <div
                        x-show="searchResults.length > 0"
                        x-cloak
                        class="absolute left-0 right-0 top-full mt-1 z-20 rounded-xl border border-base-300 bg-base-100 shadow-lg p-1 flex flex-col gap-0.5 max-h-60 overflow-y-auto"
                    >
                        <template x-for="candidate in searchResults" :key="candidate.id">
                            <button
                                type="button"
                                @click="addMember(candidate)"
                                class="w-full text-left px-2.5 py-2 rounded-lg hover:bg-base-200 flex items-center gap-2.5 text-sm cursor-pointer"
                            >
                                <template x-if="candidate.avatar">
                                    <img :src="candidate.avatar" :alt="candidate.name" class="w-6 h-6 rounded-full object-cover shrink-0" />
                                </template>
                                <template x-if="!candidate.avatar">
                                    <span class="w-6 h-6 rounded-full bg-neutral text-neutral-content text-xs uppercase flex items-center justify-center shrink-0" x-text="candidate.initials"></span>
                                </template>
                                <span class="truncate grow font-medium" x-text="candidate.name"></span>
                                <span class="text-xs text-neutral-content shrink-0" x-text="candidate.inherited_access[1] ? '{{ __('entities/permissions.share.inherited_allow') }}' : '{{ __('entities/permissions.share.inherited_deny') }}'"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <template x-if="activeMembers.length === 0">
                    <p class="text-xs text-neutral-content m-0 py-2">
                        {{ __('entities/permissions.share.members_empty') }}
                    </p>
                </template>

                <div x-show="activeMembers.length > 0" x-cloak class="flex flex-col divide-y divide-base-200 rounded-xl border border-base-300">
                    <template x-for="member in activeMembers" :key="member.id">
                        <div class="p-2.5 flex flex-col gap-2">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0 grow">
                                    <template x-if="member.avatar">
                                        <img :src="member.avatar" :alt="member.name" class="w-7 h-7 rounded-full object-cover shrink-0" />
                                    </template>
                                    <template x-if="!member.avatar">
                                        <span class="w-7 h-7 rounded-full bg-neutral text-neutral-content text-xs uppercase flex items-center justify-center shrink-0" x-text="member.initials"></span>
                                    </template>
                                    <div class="min-w-0 flex flex-col">
                                        <span class="font-medium text-sm truncate" x-text="member.name"></span>
                                        <span class="text-xs text-neutral-content" x-text="member.inherited_access[1] ? '{{ __('entities/permissions.share.inherited_allow') }}' : '{{ __('entities/permissions.share.inherited_deny') }}'"></span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-1.5 shrink-0">
                                    <select
                                        class="text-sm rounded-lg border border-base-300 bg-base-100 px-2.5 py-1.5"
                                        :value="presetFor(member, true)"
                                        @change="applyPreset(member, $event.target.value, true)"
                                    >
                                        <option value="deny">{{ __('entities/permissions.share.no_access') }}</option>
                                        <option value="view">{{ __('entities/permissions.share.view') }}</option>
                                        <option value="edit">{{ __('entities/permissions.share.edit') }}</option>
                                        <option value="custom" x-show="presetFor(member, true) === 'custom'">{{ __('entities/permissions.share.custom') }}</option>
                                    </select>
                                    <template x-if="member.switch_url">
                                        <a :href="member.switch_url" class="btn2 btn-ghost btn-xs px-1.5" title="{{ __('campaigns.members.actions.switch-entity') }}" aria-label="{{ __('campaigns.members.actions.switch-entity') }}">
                                            <x-icon class="fa-solid fa-sign-in-alt" />
                                        </a>
                                    </template>
                                    <button
                                        type="button"
                                        @click="removeMember(member)"
                                        class="btn2 btn-ghost btn-xs px-1.5 text-neutral-content hover:text-error"
                                        title="{{ __('entities/permissions.share.remove') }}"
                                        aria-label="{{ __('entities/permissions.share.remove') }}"
                                    >
                                        <x-icon class="fa-regular fa-xmark" />
                                    </button>
                                </div>
                            </div>

                            <div x-show="showAdvanced" x-cloak class="flex flex-wrap gap-1.5 pt-1">
                                @foreach ($actionMeta as $actionId => $actionLabel)
                                    <button
                                        type="button"
                                        @click="cycleAction(member, {{ $actionId }})"
                                        :class="actionBadgeClass(member.perms[{{ $actionId }}])"
                                        class="text-xs px-2 py-1 rounded-md border cursor-pointer flex items-center gap-1"
                                    >
                                        <span>{{ $actionLabel }}:</span>
                                        <strong x-text="actionLabel(member.perms[{{ $actionId }}])"></strong>
                                    </button>
                                @endforeach
                            </div>

                            @foreach ($actionMeta as $actionId => $actionLabel)
                                <input type="hidden" :name="`user[${member.id}][{{ $actionId }}]`" :value="member.perms[{{ $actionId }}]" />
                            @endforeach
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex items-center justify-between pt-1">
                <button
                    type="button"
                    @click="showAdvanced = !showAdvanced"
                    class="text-xs text-link hover:underline flex items-center gap-1.5 cursor-pointer"
                >
                    <x-icon class="fa-regular fa-sliders" />
                    <span>{{ __('entities/permissions.share.advanced') }}</span>
                    <i class="fa-regular text-2xs" :class="showAdvanced ? 'fa-chevron-up' : 'fa-chevron-down'" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    @endif
</div>
