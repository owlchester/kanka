@if (!empty($filters))
{!! Form::open(['url' => $route, 'method' => 'GET', 'id' => 'crud-filters-form']) !!}
<div class="filters" id="crud-filters">
    <div class="hidden-xs hidden-sm" id="available-filters">

        <div class="first visible-md visible-lg">{{ trans('crud.filters.title') }}</div>
        @foreach ($filters as $field)
            @if (is_array($field))
                <div class="element" data-field="{{ $field['field'] }}" data-type="{{ $field['type'] }}">
                    <?php $model = null;
                    $value = $filterService->single($field['field']);
                    if (!empty($value) && $field['type'] == 'select2') {
                        $modelclass = new $field['model'];
                        $model = $modelclass->acl()->find($value);
                    }?>
                    <label class="field" for="{{ $field['field'] }}">{{ $field['label'] }}</label>
                    <div class="value">{{ (!empty($model) ? $model->name : (!empty($value) ? trans($field['valueKey'] . $value) : null)) }}</div>
                    <div class="input" style="display:none;">
                        @if ($field['type'] == 'select')
                            {!! Form::select(
                            $field['field'],
                            array_merge(['' => ''], $field['data']), // Add an empty option
                            $value,
                            [
                                'id' => $field['field'],
                                'class' => 'form-control input-field filter-select',
                                'style' => 'width: 100%',
                            ]
                        ) !!}
                        @else
                        {!! Form::select($field['field'], (!empty($model) ? [$model->id => $model->name] : []),
                            null,
                            [
                                'id' => $field['field'],
                                'class' => 'form-control select2 input-field',
                                'style' => 'width: 100%',
                                'data-url' => $field['route'],
                                'data-placeholder' => $field['placeholder']
                            ]
                        ) !!}
                        @endif
                    </div>
                </div>
            @else
                <div class="element" data-field="{{ $field }}" data-type="text">
                    <label class="field" for="{{ $field }}">{{ trans(($field == 'is_private' ? 'crud' : $name) . '.fields.' . $field) }}</label>
                    @if ($filterService->isCheckbox($field))
                    <div class="value">{!! $filterService->single($field) !!}</div>
                    <div class="input" style="display:none;">
                        <select class="filter-select form-control" id="{{ $field }}" name="{{ $field }}">
                            <option value=""></option>
                            <option value="0" @if ($filterService->filterValue($field) === '0') selected="selected" @endif>{{ trans('voyager.generic.no') }}</option>
                            <option value="1"  @if ($filterService->filterValue($field) === '1') selected="selected" @endif>{{ trans('voyager.generic.yes') }}</option>
                        </select>
                    </div>
                    @else
                    <div class="value">{{ $filterService->single($field) }}</div>
                    <div class="input" style="display:none;">
                        <input type="text" class="input-field" name="{{ $field }}" value="{{ $filterService->single($field) }}" />
                    </div>
                    @endif
                </div>
            @endif
        @endforeach

        <div class="end">
            <label id="filters-reset">
                <i class="fa fa-eraser"></i> {{ trans('crud.filters.clear') }}
            </label>
        </div>
        <br style="clear: both;" />
    </div>
    <div class="visible-xs visible-sm text-center">
        <span href="#" id="filters-show-action">
            <i class="fa fa-angle-double-down"></i> {{ trans('crud.filters.show') }}
        </span>
        <span href="#" id="filters-hide-action" style="display:none">
            <i class="fa fa-angle-double-up"></i> {{ trans('crud.filters.hide') }}
        </span>
    </div>
</div>
{!! Form::close() !!}
@endif