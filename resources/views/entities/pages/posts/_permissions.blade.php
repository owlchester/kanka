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
        <a href="#" class="join-item btn2 btn-outline" data-toggle="modal" data-target="#post-new-user">
            <i class="fa-solid fa-user" aria-hidden="true"></i> {{ __('entities/notes.actions.add_user') }}
        </a>
        <a href="#" class="join-item btn2 btn-outline" data-toggle="modal" data-target="#post-new-role">
            <i class="fa-solid fa-users" aria-hidden="true"></i> {{ __('entities/notes.actions.add_role') }}
        </a>
    </div>
    {!! Form::hidden('permissions', true) !!}
</div>

@section('modals')
    @parent
    <div class="modal fade" id="post-new-user" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100">
                <div class="modal-header">
                    <x-dialog.close :modal="true" />
                    <h4 class="modal-title" id="myModalLabel">{{ __('entities/notes.show.advanced') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="field-user">
                        <label for="user">{{ __('crud.permissions.fields.member') }}</label>
                        @include('components.form.user', ['options' => ['dropdownParent' => '#post-new-user']])
                    </div>

                    <x-dialog.footer :modal="true" >
                        <button class="btn2 btn-primary post-perm-add" id="post-perm-user-add" data-type="user">
                            <x-icon class="plus"></x-icon> {{ __('entities/notes.actions.add_user') }}
                        </button>
                    </x-dialog.footer>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="post-new-role" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100">
                <div class="modal-header">
                    <x-dialog.close :modal="true"  />
                    <h4 class="modal-title" id="myModalLabel">{{ __('entities/notes.show.advanced') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="field-user">
                        <label for="user">{{ __('crud.permissions.fields.role') }}</label>
                        @include('components.form.role', ['options' => [
                            'dropdownParent' => '#post-new-role'
                        ]])
                    </div>

                    <x-dialog.footer :modal="true" >
                        <button class="btn2 btn-primary post-perm-add" id="post-perm-role-add" data-type="role">
                            <x-icon class="plus"></x-icon> {{ __('entities/notes.actions.add_role') }}
                        </button>
                    </x-dialog.footer>
                </div>
            </div>
        </div>
    </div>

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
@endsection
