<div class="tab-pane" id="form-permissions">
    @if(!empty($model))
        @foreach ($model->permissions()->onlyRoles()->with('role')->get() as $perm)
        <div class="row mb-5">
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa-solid fa-users" aria-hidden="true"></i></span>
                    <input type="text" value="{!! $perm->role->name !!}" disabled="disabled" class="form-control" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group">
                    {!! Form::select('perm_role_perm[]', $permissions, $perm->permission, ['class' => 'form-control']) !!}

                    <span class="input-group-btn">
                        <button class="btn btn-danger btn-flat post-delete-perm">
                            <i class='fa-solid fa-trash' aria-hidden="true"></i>
                            <span class="sr-only">{{ __('crud.remove') }}</span>
                        </button>
                    </span>
                </div>
            </div>
            <input type="hidden" name="perm_role[]" value="{{ $perm->role_id }}" />
        </div>
        @endforeach
        @foreach ($model->permissions()->onlyUsers()->with('user')->get() as $perm)
            <div class="row mb-5">
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
                        <input type="text" value="{!! $perm->user->name !!}" disabled="disabled" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        {!! Form::select('perm_user_perm[]', $permissions, $perm->permission, ['class' => 'form-control']) !!}

                        <span class="input-group-btn">
                            <button class="btn btn-danger btn-flat post-delete-perm">
                                <x-icon class="trash"></x-icon>
                            </button>
                        </span>
                    </div>
                </div>
                <input type="hidden" name="perm_user[]" value="{{ $perm->user_id }}" />
            </div>
        @endforeach
    @endif
    <div id="post-perm-target" class="mb-5"></div>
    <div class="btn-group">
        <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#post-new-user">
            <i class="fa-solid fa-user" aria-hidden="true"></i> {{ __('entities/notes.actions.add_user') }}
        </a>
        <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#post-new-role">
            <i class="fa-solid fa-users" aria-hidden="true"></i> {{ __('entities/notes.actions.add_role') }}
        </a>
    </div>
    {!! Form::hidden('permissions', true) !!}

        <div class="modal fade" id="post-new-user" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('entities/notes.show.advanced') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">{{ __('crud.permissions.fields.member') }}</label>
                        @include('components.form.user', ['options' => ['dropdownParent' => '#post-new-user']])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button class="btn btn-primary post-perm-add" id="post-perm-user-add" data-type="user">
                        <x-icon class="plus"></x-icon> {{ __('entities/notes.actions.add_user') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="post-new-role" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('entities/notes.show.advanced') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">{{ __('crud.permissions.fields.role') }}</label>
                        @include('components.form.role', ['options' => [
                            'dropdownParent' => '#post-new-role'
                        ]])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button class="btn btn-primary post-perm-add" id="post-perm-role-add" data-type="role">
                        <x-icon class="plus"></x-icon> {{ __('entities/notes.actions.add_role') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('modals')
    @parent
    <div class="hidden row mb-5" id="post-perm-user-template">
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="form-control" />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group">
                {!! Form::select('perm_user_perm[]', $permissions, null, [
                    'class' => 'form-control'
                ]) !!}
                <span class="input-group-btn">
                    <button class="btn btn-danger btn-flat post-delete-perm">
                        <x-icon class="trash"></x-icon>
                    </button>
                </span>
            </div>
        </div>
        <input type="hidden" name="perm_user[]" value="$SELECTEDID$" />
    </div>
    <div class="hidden row mb-5" id="post-perm-role-template">
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa-solid fa-users" aria-hidden="true"></i></span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="form-control" />
            </div>        </div>
        <div class="col-sm-6">
            <div class="input-group">
                {!! Form::select('perm_role_perm[]', $permissions, null, [
                    'class' => 'form-control'
                ]) !!}
                <span class="input-group-btn">
                <button class="btn btn-danger btn-flat post-delete-perm">
                    <x-icon class="trash"></x-icon>
                </button>
            </span>
            </div>
        </div>
        <input type="hidden" name="perm_role[]" value="$SELECTEDID$" />
    </div>
@endsection
