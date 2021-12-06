<div class="tab-pane" id="form-permissions">
    @if(!empty($model))
        @foreach ($model->permissions()->onlyRoles()->with('role')->get() as $perm)
        <div class="row margin-bottom">
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <input type="text" value="{!! $perm->role->name !!}" disabled="disabled" class="form-control" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group">
                    {!! Form::select('perm_role_perm[]', $permissions, $perm->permission, ['class' => 'form-control']) !!}

                    <span class="input-group-btn">
                        <button class="btn btn-danger btn-flat entity-note-delete-perm">
                            <i class='fa fa-trash'></i>
                        </button>
                    </span>
                </div>
            </div>
            <input type="hidden" name="perm_role[]" value="{{ $perm->role_id }}" />
        </div>
    @endforeach
        @foreach ($model->permissions()->onlyUsers()->with('user')->get() as $perm)
            <div class="row margin-bottom">
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" value="{!! $perm->user->name !!}" disabled="disabled" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        {!! Form::select('perm_user_perm[]', $permissions, $perm->permission, ['class' => 'form-control']) !!}

                        <span class="input-group-btn">
                            <button class="btn btn-danger btn-flat entity-note-delete-perm">
                                <i class='fa fa-trash'></i>
                            </button>
                        </span>
                    </div>
                </div>
                <input type="hidden" name="perm_user[]" value="{{ $perm->user_id }}" />
            </div>
        @endforeach
    @endif
    <div id="entity-note-perm-target" class="margin-bottom"></div>
    <div class="btn-group">
        <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#entity-note-new-user">
            <i class="fa fa-user"></i> {{ __('entities/notes.actions.add_user') }}
        </a>
        <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#entity-note-new-role">
            <i class="fa fa-users"></i> {{ __('entities/notes.actions.add_role') }}
        </a>
    </div>
    {!! Form::hidden('permissions', true) !!}

    <div class="hidden row margin-bottom" id="entity-note-perm-user-template">
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="form-control" />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group">
                {!! Form::select('perm_user_perm[]', $permissions, null, [
                    'class' => 'form-control'
                ]) !!}
                <span class="input-group-btn">
                    <button class="btn btn-danger btn-flat entity-note-delete-perm">
                        <i class='fa fa-trash'></i>
                    </button>
                </span>
            </div>
        </div>
        <input type="hidden" name="perm_user[]" value="$SELECTEDID$" />
    </div>
    <div class="hidden row margin-bottom" id="entity-note-perm-role-template">
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <input type="text" value="$SELECTEDNAME$" disabled="disabled" class="form-control" />
            </div>        </div>
        <div class="col-sm-6">
            <div class="input-group">
                {!! Form::select('perm_role_perm[]', $permissions, null, [
                    'class' => 'form-control'
                ]) !!}
                <span class="input-group-btn">
                <button class="btn btn-danger btn-flat entity-note-delete-perm">
                    <i class='fa fa-trash'></i>
                </button>
            </span>
            </div>
        </div>
        <input type="hidden" name="perm_role[]" value="$SELECTEDID$" />
    </div>

    <div class="modal fade" id="entity-note-new-user" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('entities/notes.show.advanced') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">{{ __('crud.permissions.fields.member') }}</label>
                        {!! Form::user('user', ['dropdownParent' => '#entity-note-new-user']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button class="btn btn-primary entity-note-perm-add" id="entity-note-perm-user-add" data-type="user">
                        <i class="fa fa-plus"></i> {{ __('entities/notes.actions.add_user') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="entity-note-new-role" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('entities/notes.show.advanced') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">{{ __('crud.permissions.fields.role') }}</label>
                        {!! Form::role('role', ['dropdownParent' => '#entity-note-new-role']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button class="btn btn-primary entity-note-perm-add" id="entity-note-perm-role-add" data-type="role">
                        <i class="fa fa-plus"></i> {{ __('entities/notes.actions.add_role') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
