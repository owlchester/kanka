<div class="btn-group margin-r-5">
    <button class="btn btn-default" id="attribute_add" data-sortable="{{ $existing ? 'true' : 'false'}}">
        <i class="fa fa-plus"></i> <span class="hidden-xs">{{ trans('crud.attributes.types.attribute') }}</span>
    </button>
    <button class="btn btn-default" id="checkbox_add" data-sortable="{{ $existing ? 'true' : 'false'}}">
        <i class="fa fa-check"></i> <span class="hidden-xs">{{ trans('crud.attributes.types.checkbox') }}</span>
    </button>
    <button class="btn btn-default" id="text_add" data-sortable="{{ $existing ? 'true' : 'false'}}">
        <i class="fas fa-align-justify"></i> <span class="hidden-xs">{{ trans('crud.attributes.types.text') }}</span>
    </button>
</div>