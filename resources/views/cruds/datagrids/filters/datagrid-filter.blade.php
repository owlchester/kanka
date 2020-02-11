@php
/**
 * @var \App\Datagrids\Filters\DatagridFilter $filter
 * @var \App\Services\FilterService $filterService
 */
$filters = $filter->filters();
$activeFilters = count($filterService->activeFilters());
@endphp

<div class="box no-border datagrid-filters">
    <div class="box-header" data-toggle="collapse" data-target="#datagrid-filters">

        <i class="fa fa-chevron-down pull-right"></i>
        <i class="fa fa-filter"></i> {{ __('crud.filter') }}

        @if ($activeFilters > 0)
            <span class="label label-danger">{{ $activeFilters }}</span>
        @endif

    </div>

    <div class="box-body collapse out" id="datagrid-filters">
        {!! Form::open(['url' => route($route . '.index'), 'method' => 'GET', 'id' => 'crud-filters-form']) !!}
        <div class="row" >
            @foreach ($filters as $field)
                <div class="col-md-6">
                    <div class="form-group">
                        @if (is_array($field))
                            <?php $model = null;
                            $value = $filterService->single($field['field']);
                            if (!empty($value) && $field['type'] == 'select2') {
                                $modelclass = new $field['model'];
                                $model = $modelclass->find($value);
                            }?>
                            @if ($field['type'] == 'tag')
                                {!! Form::hidden($field['field'], null) !!}
                                {!! Form::tags(
                                    $field['field'],
                                    [
                                        'id' => $field['field'] . '_' . uniqid(),
                                        'model' => null,
                                        'enableNew' => false,
                                        'allowClear' => 'false',
                                        'filterOptions' => $value
                                    ]
                                ) !!}
                            @elseif ($field['type'] == 'select')
                                {!! Form::select(
                                $field['field'],
                                array_merge(['' => ''], $field['data']), // Add an empty option
                                $value,
                                [
                                    'id' => $field['field'],
                                    'class' => 'form-control select2',
                                    'style' => 'width: 100%',
                                ]
                            ) !!}
                            @else
                                {!! Form::select($field['field'], (!empty($model) ? [$model->id => $model->name] : []),
                                    null,
                                    [
                                        'id' => $field['field'],
                                        'class' => 'form-control select2',
                                        'data-url' => $field['route'],
                                        'data-placeholder' => $field['placeholder'],
                                        'style' => 'width: 100%',
                                    ]
                                ) !!}
                            @endif
                        @else
                            @if ($filterService->isCheckbox($field))
                                <select class="filter-select form-control" id="{{ $field }}" name="{{ $field }}">
                                    <option value="">{{ trans(($field == 'is_private' ? 'crud.fields.' : $name . '.fields.') . $field) }}</option>
                                    <option value="0" @if ($filterService->filterValue($field) === '0') selected="selected" @endif>{{ trans('voyager.generic.no') }}</option>
                                    <option value="1"  @if ($filterService->filterValue($field) === '1') selected="selected" @endif>{{ trans('voyager.generic.yes') }}</option>
                                </select>
                            @else
                                <input type="text" class="form-control" name="{{ $field }}" value="{{ $filterService->single($field) }}" placeholder="{{ trans(($field == 'is_private' ? 'crud.fields.' : $name . '.fields.') . $field) }}" />
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <button class="btn btn-primary">{{ __('crud.filter') }}</button>

        <a href="{{ route($route . '.index', ['reset-filter' => 'true']) }}" class="btn btn-default pull-right">
            <i class="fa fa-eraser"></i> {{ trans('crud.filters.clear') }}
        </a>

        {!! Form::close() !!}
    </div>
</div>
