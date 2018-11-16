@can('attribute', [$model, 'add'])
    <p class="text-right">
        <a class="btn btn-primary" href="{{ route('entities.attributes.template', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', $model->entity) }}">
            <i class="fa fa-copy"></i> <span class="hidden-xs hidden-sm">{{ trans('crud.attributes.actions.apply_template') }}</span>
        </a>

        <a href="{{ route('entities.attributes.index', ['entity' => $model->entity]) }}" class="btn btn-primary">
            <i class="fa fa-list"></i> <span class="hidden-xs hidden-sm">{{ trans('crud.attributes.actions.manage') }}</span>
        </a>

        {{--<a href="{{ route('entities.attributes.create', ['entity' => $model->entity]) }}" class="btn btn-primary">--}}
            {{--<i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans('crud.attributes.actions.add') }}</span>--}}
        {{--</a>--}}
    </p>
@endcan
<?php $r = $model->entity->attributes()->order(request()->get('order'), 'default_order')->paginate(); ?>
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
        @if (Auth::check() && Auth::user()->isAdmin())
            <th>
                <a href="{{ route($name . '.show', [$model, 'order' => 'attributes/is_private', '#attribute']) }}">
                    {{ trans('crud.fields.is_private') }}
                    @if (request()->get('order') == 'attributes/is_private') <i class="fa fa-long-arrow-down"></i>@endif
                </a>
            </th>
        @endif
    </tr>
    @foreach ($r as $attribute)
        <tr>
            <td>{{ $attribute->name }}</td>
            <td>
                @if ($attribute->isCheckbox())
                    @if ($attribute->value)
                        <i class="fa fa-check"></i>
                    @endif
                @else
                {{ $attribute->value }}
                @endif
            </td>
            @if (Auth::check() && Auth::user()->isAdmin())
                <td>
                    @if ($attribute->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_attribute')->links() }}
