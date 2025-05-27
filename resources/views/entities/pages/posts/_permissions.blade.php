<div class="tab-pane" id="form-permissions">
    <div class="max-w-4xl flex flex-col gap-2">
        @if(!empty($model))
            @foreach ($model->permissions()->onlyRoles()->with('role')->get() as $perm)
                <x-grid class="perm-row">
                    <div class="join">
                        <span class="join-item flex items-center p-2">
                            <x-icon class="fa-regular fa-users" />
                        </span>
                        <input type="text" value="{!! $perm->role->name !!}" disabled="disabled" class="" />
                    </div>

                    <div class="flex items-center gap-2">
                        <x-forms.select name="perm_role_perm[]" :options="$permissions" :selected="$perm->permission" class="grow" />
                        <a role="button" class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                            <x-icon class="trash" />
                            <span class="sr-only">{{ __('crud.remove') }}</span>
                        </a>
                    </div>
                    <input type="hidden" name="perm_role[]" value="{{ $perm->role_id }}" />
                </x-grid>
            @endforeach
            @foreach ($model->permissions()->onlyUsers()->with('user')->get() as $perm)
                <x-grid class="perm-row">
                    <div class="join">
                        <span class="join-item flex items-center p-2">
                            <x-icon class="fa-regular fa-user" />
                        </span>
                        <input type="text" value="{!! $perm->user->name !!}" disabled="disabled" class="w-full" />
                    </div>

                    <div class="flex items-center gap-2">
                        <x-forms.select name="perm_user_perm[]" :options="$permissions" :selected="$perm->permission" class="grow" />

                        <a role="button" class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                            <x-icon class="trash" />
                        </a>
                    </div>
                    <input type="hidden" name="perm_user[]" value="{{ $perm->user_id }}" />
                </x-grid>
            @endforeach
        @endif
        <div id="post-perm-target" class=""></div>
    </div>
    <div class="join">
        <a href="#" class="join-item btn2 btn-outline" data-toggle="dialog" data-target="post-new-user">
            <x-icon class="fa-regular fa-user" />
            {{ __('posts.permissions.actions.members') }}
        </a>
        <a href="#" class="join-item btn2 btn-outline" data-toggle="dialog" data-target="post-new-role">
            <x-icon class="fa-regular fa-users" />
            {{ __('posts.permissions.actions.roles') }}
        </a>
    </div>
    <input type="hidden" name="permissions" value="1" />
</div>

@section('modals')
    @parent
    <x-dialog id="post-new-user" :title="__('entities/notes.show.advanced')" footer="entities.pages.posts.dialogs._user-footer">
        <x-grid type="1/1">
            <x-helper>
                {{ __('posts.permissions.helpers.members') }}
            </x-helper>
            <x-forms.field field="user" :label="__('campaigns.roles.members')">
                @include('components.form.user', ['options' => [
                    'dropdownParent' => '#post-new-user',
                    'multiple' => true
                ]])
            </x-forms.field>
        </x-grid>
    </x-dialog>
    <x-dialog id="post-new-role" :title="__('entities/notes.show.advanced')" footer="entities.pages.posts.dialogs._role-footer">
        <x-grid type="1/1">
            <x-helper>{{ __('posts.permissions.helpers.roles') }}</x-helper>
            <x-forms.field field="user" :label="__('crud.permissions.fields.role')">
                @include('components.form.role', ['options' => [
                    'dropdownParent' => '#post-new-role',
                    'multiple' => true,
                ]])
            </x-forms.field>
        </x-grid>
    </x-dialog>

    <div class="hidden" id="post-perm-templates">
        <x-grid id="post-perm-user-template" class="perm-row">
            <div class="join">
                <span class="join-item flex items-center p-2">
                    <x-icon class="fa-regular fa-user" />
                </span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="w-full join-item" />
            </div>

            <div class="flex items-center gap-2">
                <x-forms.select name="perm_user_perm[]" :options="$permissions" class="grow" />
                <a role="button" class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                    <x-icon class="trash" />
                </a>
            </div>
            <input type="hidden" name="perm_user[]" value="$SELECTEDID$" />
        </x-grid>
        <x-grid id="post-perm-role-template" class="perm-row">
            <div class="join">
                <span class="join-item flex items-center p-2">
                    <x-icon class="fa-regular fa-users" />
                </span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="w-full join-item" />
            </div>
            <div class="flex items-center gap-2">
                <x-forms.select name="perm_role_perm[]" :options="$permissions" class="grow" />
                <a role="button" class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                    <x-icon class="trash" />
                </a>
            </div>
            <input type="hidden" name="perm_role[]" value="$SELECTEDID$" />
        </x-grid>
    </div>
@endsection
