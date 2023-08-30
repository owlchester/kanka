<div class="tab-pane" id="form-permissions">
    <div class="max-w-4xl">
    @if(!empty($model))
        @foreach ($model->permissions()->onlyRoles()->with('role')->get() as $perm)
            <x-grid>
                <div class="join">
                    <span class="join-item flex items-center bg-base-200 p-2 rounded">
                        <i class="fa-solid fa-users" aria-hidden="true"></i>
                    </span>
                    <input type="text" value="{!! $perm->role->name !!}" disabled="disabled" class="form-control" />
                </div>

                <div class="flex items-center gap-2">
                    {!! Form::select('perm_role_perm[]', $permissions, $perm->permission, ['class' => 'form-control grow']) !!}

                    <button class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                        <x-icon class="trash"></x-icon>
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </button>
                </div>
                <input type="hidden" name="perm_role[]" value="{{ $perm->role_id }}" />
            </x-grid>
        @endforeach
        @foreach ($model->permissions()->onlyUsers()->with('user')->get() as $perm)
            <x-grid>
                <div class="join">
                    <span class="join-item flex items-center bg-base-200 p-2 rounded">
                        <i class="fa-solid fa-user" aria-hidden="true"></i>
                    </span>
                    <input type="text" value="{!! $perm->user->name !!}" disabled="disabled" class="form-control" />
                </div>

                <div class="flex items-center gap-2">
                    {!! Form::select('perm_user_perm[]', $permissions, $perm->permission, ['class' => 'form-control grow']) !!}

                    <button class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                        <x-icon class="trash"></x-icon>
                    </button>
                </div>
                <input type="hidden" name="perm_user[]" value="{{ $perm->user_id }}" />
            </x-grid>
        @endforeach
    @endif
    <div id="post-perm-target" class="mb-5"></div>
    </div>
    <div class="join">
        <a href="#" class="join-item btn2 btn-outline" data-toggle="dialog" data-target="post-new-user">
            <i class="fa-solid fa-user" aria-hidden="true"></i> {{ __('entities/notes.actions.add_user') }}
        </a>
        <a href="#" class="join-item btn2 btn-outline" data-toggle="dialog" data-target="post-new-role">
            <i class="fa-solid fa-users" aria-hidden="true"></i> {{ __('entities/notes.actions.add_role') }}
        </a>
    </div>
    {!! Form::hidden('permissions', true) !!}
</div>

@section('modals')
    @parent
    <x-dialog id="post-new-user" :title="__('entities/notes.show.advanced')" footer="entities.pages.posts.dialogs._user-footer">
        <x-grid type="1/1">
            <x-forms.field field="user" :label="__('crud.permissions.fields.member')">
                @include('components.form.user', ['options' => ['dropdownParent' => '#post-new-user']])
            </x-forms.field>
        </x-grid>
    </x-dialog>
    <x-dialog id="post-new-role" :title="__('entities/notes.show.advanced')" footer="entities.pages.posts.dialogs._role-footer">
        <x-grid type="1/1">
            <x-forms.field field="user" :label="__('crud.permissions.fields.role')">
                @include('components.form.role', ['options' => [
                    'dropdownParent' => '#post-new-role'
                ]])
            </x-forms.field>
        </x-grid>
    </x-dialog>

    <div class="hidden">
        <x-grid id="post-perm-user-template">
            <div class="join">
                <span class="join-item flex items-center bg-base-200 p-2 rounded"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="form-control join-item" />
            </div>

            <div class="flex items-center gap-2">
                {!! Form::select('perm_user_perm[]', $permissions, null, [
                    'class' => 'form-control grow'
                ]) !!}
                <button class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                    <x-icon class="trash"></x-icon>
                </button>
            </div>
            <input type="hidden" name="perm_user[]" value="$SELECTEDID$" />
        </x-grid>
        <x-grid id="post-perm-role-template">
            <div class="join">
                <span class="join-item flex items-center bg-base-200 p-2 rounded"><i class="fa-solid fa-users" aria-hidden="true"></i></span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="form-control join-item" />
            </div>
            <div class="flex items-center gap-2">
                {!! Form::select('perm_role_perm[]', $permissions, null, [
                    'class' => 'form-control grow'
                ]) !!}
                <button class="btn2 btn-error btn-sm btn-outline post-delete-perm">
                    <x-icon class="trash"></x-icon>
                </button>
            </div>
            <input type="hidden" name="perm_role[]" value="$SELECTEDID$" />
        </x-grid>
        </div>
@endsection
