@can('attribute', [$model, 'add'])
    <p class="text-right">
        @if ($model->getEntityType() != 'attribute_template' && Auth::user()->isAdmin())
            <a class="btn btn-primary" href="{{ route('entities.attributes.template', $model->entity) }}" data-toggle="modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', $model->entity) }}">
                <i class="fa fa-copy"></i> {{ trans('crud.attributes.actions.apply_template') }}
            </a>
        @endif

        <a href="{{ route('entities.attributes.index', ['entity' => $model->entity]) }}" class="btn btn-primary">
            <i class="fa fa-list"></i> {{ trans('crud.attributes.actions.manage') }}
        </a>

        <a href="{{ route('entities.attributes.create', ['entity' => $model->entity]) }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> {{ trans('crud.attributes.actions.add') }}
        </a>
    </p>
@endcan
<?php $r = $model->entity->attributes()->order(request()->get('order'))->paginate(); ?>
<p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('crud.tabs.attributes') }}</p>
<table id="crud_attributes" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <tbody><tr>
        <th>
            <a href="{{ route($name . '.show', [$model, 'order' => 'attributes/name', '#attribute']) }}">
                {{ trans('crud.attributes.fields.attribute') }}
                @if (request()->get('order') == 'attributes/name') <i class="fa fa-long-arrow-down"></i>@endif
            </a>
        </th>
        <th>
            <a href="{{ route($name . '.show', [$model, 'order' => 'attributes/value', '#attribute']) }}">
                {{ trans('crud.attributes.fields.value') }}
                @if (request()->get('order') == 'attributes/value') <i class="fa fa-long-arrow-down"></i>@endif
            </a>
        </th>
        @if (Auth::user()->isAdmin())
            <th>
                <a href="{{ route($name . '.show', [$model, 'order' => 'attributes/is_private', '#attribute']) }}">
                    {{ trans('crud.fields.is_private') }}
                    @if (request()->get('order') == 'attributes/is_private') <i class="fa fa-long-arrow-down"></i>@endif
                </a>
            </th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($r as $attribute)
        <tr>
            <td>{{ $attribute->name }}</td>
            <td>{{ $attribute->value }}</td>
            @if (Auth::user()->isAdmin())
                <td>
                    @if ($attribute->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
            <td class="text-right">
                @can('attribute', [$model, 'edit'])
                    <a href="{{ route('entities.attributes.edit', ['entity' => $model->entity, 'attribute' => $attribute]) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{ trans('crud.edit') }}</a>
                @endcan
                @can('attribute', [$model, 'delete'])
                {!! Form::open(['method' => 'DELETE','route' => ['entities.attributes.destroy', 'entity' => $model->entity, 'attribute' => $attribute],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_attribute')->links() }}
