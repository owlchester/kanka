@if (!empty($filters))
<?php $filterColWidth = count($filters) > 8 ? 6 : 12; ?>
    {!! Form::open(['url' => route($route), 'method' => 'GET', 'id' => 'crud-filters-form']) !!}
    <div class="row">
    @foreach ($filters as $field)
        <div class="col-md-{{ is_array($field) ? 12 : $filterColWidth }}">
            <div class="form-group">
            @if (is_array($field))
                <?php $model = null;
                $value = $filterService->single($field['field']);
                if (!empty($value) && $field['type'] == 'select2') {
                    $modelclass = new $field['model'];
                    $model = $modelclass->find($value);
                }?>
                @if ($field['type'] == 'tag')
                    {!! Form::tags(
                        $field['field'],
                        [
                            'id' => $field['field'],
                            'model' => null,
                            'enableNew' => false,
                            'label' => false
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
                    ]
                ) !!}
                @else
                {!! Form::select($field['field'], (!empty($model) ? [$model->id => $model->name] : []),
                    null,
                    [
                        'id' => $field['field'],
                        'class' => 'form-control select2',
                        'data-url' => $field['route'],
                        'data-placeholder' => $field['placeholder']
                    ]
                ) !!}
                @endif
            @else
                    @if ($filterService->isCheckbox($field))
                    <select class="filter-select form-control" id="{{ $field }}" name="{{ $field }}">
                        <option value="">{{ trans(($field == 'is_private' ? 'crud.fields.' : $name) . $field) }}</option>
                        <option value="0" @if ($filterService->filterValue($field) === '0') selected="selected" @endif>{{ trans('voyager.generic.no') }}</option>
                        <option value="1"  @if ($filterService->filterValue($field) === '1') selected="selected" @endif>{{ trans('voyager.generic.yes') }}</option>
                    </select>
                    @else
                        <input type="text" class="form-control" name="{{ $field }}" value="{{ $filterService->single($field) }}" placeholder="{{ trans(($field == 'is_private' ? 'crud.fields' : $name) . $field) }}" />
                    @endif
            @endif
            </div>
        </div>
    @endforeach
</div>
<button class="btn btn-primary">{{ __('crud.filter') }}</button>

<a href="{{ route($route, ['reset-filter' => 'true']) }}" class="btn btn-default pull-right">
    <i class="fa fa-eraser"></i> {{ trans('crud.filters.clear') }}
</a>

{!! Form::close() !!}
@endif
