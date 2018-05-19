@if (!empty($filters))
{!! Form::open(['url' => $route, 'method' => 'GET', 'id' => 'crud-filters-form']) !!}
<div class="filters" id="crud-filters">
    <div class="first">{{ trans('crud.filters') }}</div>

    @foreach ($filters as $field)
        @if (is_array($field))
            <div class="element" data-field="{{ $field['field'] }}" data-type="select2">
                <?php $model = null;
                $value = $filterService->single($field['field']);
                if (!empty($value)) {
                    $modelclass = new $field['model'];
                    $model = $modelclass->acl(auth()->user())->find($value);
                }?>
                <label class="field" for="{{ $field['field'] }}">{{ $field['label'] }}</label>
                <div class="value">{{ (!empty($model) ? $model->name : null) }}</div>
                <div class="input" style="display:none;">
                    {!! Form::select($field['field'], (!empty($model) ? [$model->id => $model->name] : []),
                                null, ['id' => $field['field'], 'class' => 'form-control select2 input-field', 'style' => 'width: 100%', 'data-url' => $field['route'], 'data-placeholder' => $field['placeholder']]) !!}
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
        <label>
            <i class="fa fa-eraser"></i> {{ trans('crud.clear_filters') }}
        </label>
    </div>
    <br style="clear: both;" />
</div>
{!! Form::close() !!}
@endif