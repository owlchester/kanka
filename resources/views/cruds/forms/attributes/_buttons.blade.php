
<div class="btn-group margin-r-5">
    <button type="button" class="btn btn-default" id="attribute_add" data-sortable="{{ $existing ? 'true' : 'false'}}">
        <i class="fa fa-plus"></i> {{ trans('crud.attributes.types.attribute') }}
    </button>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        {{ __('crud.attributes.actions.more') }}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="#" id="checkbox_add" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa fa-check"></i> {{ trans('crud.attributes.types.checkbox') }}
            </a>
        </li>
        <li>
            <a href="#" id="text_add" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa fas fa-align-justify"></i> {{ trans('crud.attributes.types.text') }}
            </a>
        </li>
        <li>
            <a  href="#" id="section_add" data-sortable="{{ $existing ? 'true' : 'false'}}">
                <i class="fa fas fa-layer-group"></i> {{ trans('crud.attributes.types.section') }}
            </a>
        </li>
    </ul>


</div>

<a href="{{ route('helpers.attributes') }}" data-url="{{ route('helpers.attributes') }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('helpers.attributes.description', [
    'mention' => '[entity:id]',
    'attribute' => '{' . __('helpers.attributes.level') . '}',
]) }}">
    {{ __('helpers.attributes.link') }} <i class="fa fa-question-circle"></i>
</a>
<a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#attributes-delete-all-confirm">
    <i class="fa fa-trash"></i> <span class="hidden-xs">{{ __('crud.attributes.actions.remove_all') }}</span>
</a>


<!-- Modal -->
<div class="modal fade" id="attributes-delete-all-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('crud.delete_modal.title') }}</h4>
            </div>
            <div class="modal-body">
                <p>
                    {!! trans('crud.attributes.helpers.delete_all') !!}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="attributes-delete-all-confirm-submit"><span class="fa fa-trash"></span> {{ trans('crud.delete_modal.delete') }}</button>
            </div>
        </div>
    </div>
</div>

@if (Auth::user()->isAdmin())
    <hr />
    <div class="form-group">
        {!! Form::hidden('is_attributes_private', 0) !!}
        <label>{!! Form::checkbox('is_attributes_private', 1, empty($model) ? false : $model->entity->is_attributes_private) !!}
            {{ trans('crud.attributes.fields.is_private') }}
        </label>
        <p class="help-block">{{ trans('crud.attributes.hints.is_private') }}</p>
    </div>
@endif
