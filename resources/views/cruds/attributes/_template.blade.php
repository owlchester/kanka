
<div class="panel panel-default">
    @if ($ajax)
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
        <h4>{{ trans('crud.attributes.template.title', ['name' => $entity->name]) }}</h4>
    </div>
    @endif
    <div class="panel-body">
        {!! Form::open(['route' => ['entities.attributes.template', $entity->id], 'method'=>'POST', 'data-shortcut' => '1']) !!}
        {{ csrf_field() }}
        <div class="form-group required">
            <label>{{ trans('crud.attributes.fields.template') }}</label>
            {!! Form::select('template_id', \App\Models\AttributeTemplate::orderBy('name', 'ASC')->pluck('name', 'id'), null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{ trans('crud.attributes.fields.community_templates') }}</label>
            {!! Form::select('template', $communityTemplates, null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}
        </div>

        {!! Form::hidden('entity_id', $entity->id) !!}

        <div class="form-group">
            <button class="btn btn-success">{{ trans('crud.actions.apply') }}</button>
            @if (!$ajax)
            {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '?tab=') === false ? '?tab=attribute' : null))]) !!}
            @endif
        </div>

        {!! Form::close() !!}
    </div>
</div>