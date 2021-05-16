<?php
/**
 * @var \App\Models\EntityNotePermission $perm
 */
$permissions = [
    0 => __('crud.view'),
    1 => __('crud.edit'),
    2 => __('crud.permissions.actions.bulk.deny')
];
?>

{{ csrf_field() }}
<div class="form-group required">
    {!! Form::text('name', null, ['placeholder' => __('entities/notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>

<div class="form-group">
    {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('entities/notes.fields.position') }}</label>
            {!! Form::number('position', null, ['class' => 'form-control', 'min' => 0, 'max' => 128, 'maxlength' => 3, 'increment' => 1]) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('settings[collapsed]', 0) !!}
            <label>{!! Form::checkbox('settings[collapsed]', 1, null) !!}
                {{ __('entities/notes.fields.collapsed') }}
            </label>
        </div>
    </div>
    <div class="col-md-6">
        @include('cruds.fields.visibility')
    </div>
</div>

@if(auth()->user()->isAdmin())
    <hr />
    <h4>{{ __('entities/notes.show.advanced') }}</h4>
    @if(!empty($model))
        @foreach ($model->permissions()->with('user')->get() as $perm)
            <div class="row margin-bottom">
                <div class="col-sm-6">
                    {!! $perm->user->name !!}
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        {!! Form::select('perm_perm[]', $permissions, $perm->permission, ['class' => 'form-control']) !!}

                        <span class="input-group-btn">
                        <button class="btn btn-secondary btn-flat entity-note-delete-perm">
                            <i class='fa fa-trash text-danger'></i>
                        </button>
                        </span>
                    </div>
                </div>
                <input type="hidden" name="perm_user[]" value="{{ $perm->user_id }}" />
            </div>
        @endforeach
    @endif
    <div id="entity-note-perm-target" class="margin-bottom"></div>
    <div class="text-right margin-bottom">
        <span class="btn btn-default btn-flat" data-toggle="modal" data-target="#entity-note-new-user">
            <i class="fa fa-plus"></i> {{ __('entities/notes.actions.add_user') }}
        </span>
    </div>
    {!! Form::hidden('permissions', true) !!}

    <div class="hidden row margin-bottom" id="entity-note-perm-template">
        <div class="col-sm-6">
            $USERNAME$
        </div>
        <div class="col-sm-6">
            <div class="input-group">
                {!! Form::select('perm_perm[]', $permissions, null, [
                    'class' => 'form-control'
                ]) !!}
                <span class="input-group-btn">
                    <button class="btn btn-secondary btn-flat entity-note-delete-perm">
                        <i class='fa fa-trash text-danger'></i>
                    </button>
                </span>
            </div>
        </div>
        <input type="hidden" name="perm_user[]" value="$USERID$" />
    </div>

    <div class="modal fade" id="entity-note-new-user" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('entities/notes.show.advanced') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">{{ __('campaigns.roles.users.fields.name') }}</label>
                        {!! Form::user() !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.cancel') }}</button>
                    <button class="btn btn-primary" id="entity-note-perm-add">
                        <i class="fa fa-plus"></i> {{ __('entities/notes.actions.add_user') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
{!! Form::hidden('entity_id', $entity->id) !!}
