
<div class="panel panel-default">
    @if ($ajax)
    <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
        <h4>{{ trans('crud.attributes.template.title', ['name' => $entity->name]) }}</h4>
    </div>
    @endif
    <div class="panel-body">
        {!! Form::open(array('route' => ['entities.attributes.template', $entity->id], 'method'=>'POST', 'data-shortcut' => "1")) !!}
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group required">
                    <label>{{ trans('crud.attributes.fields.template') }}</label>
                    {!! Form::select('template_id', \App\Models\AttributeTemplate::pluck('name', 'id'), null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>

        {!! Form::hidden('entity_id', $entity->id) !!}

        <div class="form-group">
            <button class="btn btn-success">{{ trans('crud.save') }}</button>
            @if (!$ajax)
            {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '?tab=') === false ? '?tab=attribute' : null))]) !!}
            @endif
        </div>

        {!! Form::close() !!}
    </div>
</div>