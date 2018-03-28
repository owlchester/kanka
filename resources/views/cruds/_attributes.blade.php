@can('attribute', [$model, 'add'])
    <p class="text-right">
        @if ($model->getEntityType() != 'attribute_template' && Auth::user()->isAdmin())
            <a href="{{ route('entities.attributes.template', ['entity' => $model->entity]) }}" class="btn btn-primary">
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

<table id="crud_attributes" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('crud.attributes.fields.attribute') }}</th>
        <th>{{ trans('crud.attributes.fields.value') }}</th>
        @if (Auth::user()->isAdmin())
            <th>{{ trans('crud.fields.is_private') }}</th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->entity->attributes()->orderBy('name', 'ASC')->paginate() as $attribute)
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

{{ $r->appends('tab', 'attribute')->links() }}
