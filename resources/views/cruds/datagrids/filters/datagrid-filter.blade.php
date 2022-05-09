@php
/**
 * @var \App\Datagrids\Filters\DatagridFilter $filter
 * @var \App\Services\FilterService $filterService
 */
use Illuminate\Support\Arr;
$filters = $filter->filters();
$activeFilters = $filterService->activeFiltersCount();
$entityModel = $model;
$count = 0;
$clipboardFilters = $filterService->clipboardFilters();

@endphp

<div class="box no-border datagrid-filters">
    <div class="box-header" data-toggle="collapse" data-target="#datagrid-filters">

        <i class="fa-solid fa-chevron-down pull-right"></i>
        <i class="fa-solid fa-filter"></i> {{ __('crud.filters.title') }}

        @if ($activeFilters > 0)
            <span class="label label-danger">{{ $activeFilters }}</span>
            <div class="box-tools">
                <a href="{{ route($route, ['reset-filter' => 'true']) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-eraser"></i> {{ __('crud.filters.clear') }}
                </a>
            </div>
        @endif
    </div>

    {!! Form::open(['url' => route($route), 'method' => 'GET', 'id' => 'crud-filters-form']) !!}
    <div class="collapse out" id="datagrid-filters">
        <div class="box-body">
            <div class="row">
                @foreach ($filters as $field)
                    @if ($count % 2 === 0 || (is_string($field) && $field == 'attributes'))
                </div>
                <div class="row">
                    @endif
                    @php $count++ @endphp

                    @if (!is_array($field) && $field === 'attributes')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('entities/attributes.filters.name') }}</label>
                                <input type="text" class="form-control" name="attribute_name" value="{{ $filterService->single('attribute_name') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('entities/attributes.filters.value') }}</label>
                                <input type="text" class="form-control" name="attribute_value" value="{{ $filterService->single('attribute_value') }}" />
                            </div>
                        </div>
                        @continue
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            @if (is_array($field))
                                <label>{{ Arr::get($field, 'label', __('crud.fields.' . $field['field'])) }}</label>
                                <?php $model = null;
                                $value = $filterService->single($field['field']);
                                if (!empty($value) && $field['type'] == 'select2') {
                                    $modelclass = new $field['model'];
                                    $model = $modelclass->find($value);
                                }?>
                                @if ($field['type'] == 'tag')
                                    <div class="row">
                                        <div class="col-xs-8">
                                            {!! Form::tags(
                                                $field['field'],
                                                [
                                                    'id' => $field['field'] . '_' . uniqid(),
                                                    'model' => null,
                                                    'enableNew' => false,
                                                    'allowClear' => 'false',
                                                    'label' => false,
                                                    'filterOptions' => $value
                                                ]
                                            ) !!}
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::select(
                                                $field['field'] . '_option',
                                                [
                                                    '' => __('crud.filters.options.include'),
                                                    'exclude' => __('crud.filters.options.exclude'),
                                                    'none' => __('crud.filters.options.none'),
                                                ],
                                                $filterService->single($field['field'] . '_option'), [
                                                    'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                @elseif ($field['type'] == 'select')
                                    <input type="hidden" name="{{ $field['id'] }}" value="" />
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
                                    <div class="row">
                                        <div class="col-xs-8">
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
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::select(
                                                $field['field'] . '_option',
                                                [
                                                    '' => __('crud.filters.options.include'),
                                                    'exclude' => __('crud.filters.options.exclude'),
                                                    'none' => __('crud.filters.options.none'),
                                                ],
                                                $filterService->single($field['field'] . '_option'), [
                                                    'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <label>{{ __((in_array($field, ['is_private', 'has_image', 'has_attributes', 'has_entity_files', 'has_entity_notes']) ? 'crud.fields.' : $langKey . '.fields.') . $field) }}</label>
                                @if ($filterService->isCheckbox($field))
                                    <select class="filter-select form-control" id="{{ $field }}" name="{{ $field }}">
                                        <option value=""></option>
                                        <option value="0" @if ($filterService->filterValue($field) === '0') selected="selected" @endif>{{ __('voyager.generic.no') }}</option>
                                        <option value="1"  @if ($filterService->filterValue($field) === '1') selected="selected" @endif>{{ __('voyager.generic.yes') }}</option>
                                    </select>
                                @elseif ($field === 'type' && !empty($entityModel))

                                    <input type="text" class="form-control" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-type-list" />
                                    <div class="hidden">
                                        <datalist id="entity-type-list">
                                            @foreach (\App\Facades\EntityCache::typeSuggestion($entityModel) as $suggestion)
                                                <option value="{{ $suggestion }}">{{ $suggestion }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                @elseif ($field === 'sex' && !empty($entityModel))

                                    <input type="text" class="form-control" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-gender-list" />
                                    <div class="hidden">
                                        <datalist id="entity-gender-list">
                                            @foreach (\App\Facades\CharacterCache::genderSuggestion() as $suggestion)
                                                <option value="{{ $suggestion }}">{{ $suggestion }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                @elseif ($field === 'date')
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa-solid fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control date-picker" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" />
                                    </div>
                                @else
                                    <input type="text" class="form-control" name="{{ $field }}" value="{{ $filterService->single($field) }}" />
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box-footer text-center">
            <div class="pull-left hidden-xs">
                <a href="{{ route($route, ['reset-filter' => 'true']) }}" class="btn btn-default">
                    <i class="fa-solid fa-eraser"></i> {{ __('crud.filters.clear') }}
                </a>


                @if($activeFilters > 0)
                <a href="#" class="btn btn-default margin-r-5" data-clipboard="{{ $clipboardFilters }}" data-toggle="tooltip" title="{{ __('crud.filters.copy_helper') }}">
                    <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.copy_to_clipboard') }}
                </a>
                @else
                    <div class="visible-lg-inline-block visible-md-inline-block visible-sm-inline-block margin-r-5" data-toggle="tooltip" title="{{ __('crud.filters.copy_helper_no_filters') }}">
                    <a href="#" class="btn btn-default" style="pointer-events: none;" disabled >
                        <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.copy_to_clipboard') }}
                    </a>
                    </div>
                @endif

                <a href="{{ route('helpers.filters') }}" data-url="{{ route('helpers.filters') }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('helpers.filters.title') }}">
                    {{ __('helpers.filters.title') }} <i class="fa-solid fa-question-circle"></i>
                </a>
            </div>

            <div class="visible-xs pull-left block">
                <a href="{{ route($route, ['reset-filter' => 'true']) }}" class="btn btn-default margin-r-5">
                    <i class="fa-solid fa-eraser"></i> {{ __('crud.filters.mobile.clear') }}
                </a>

                @if($activeFilters > 0)
                <a href="#" class="btn btn-default margin-r-5" data-clipboard="{{ $clipboardFilters }}" data-toggle="tooltip">
                    <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.mobile.copy') }}
                </a>
            @else
                <a href="#" class="btn btn-default margin-r-5" disabled="disabled" data-toggle="tooltip" title="{{ __('crud.filters.copy_helper_no_filters') }}">
                    <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.mobile.copy') }}
                </a>
                @endif

                <a href="{{ route('helpers.filters') }}" data-url="{{ route('helpers.filters') }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('helpers.filters.title') }}">
                    <i class="fa-solid fa-question-circle"></i>
                </a>
            </div>


            <span class="pull-right">
                <button type="submit" class="btn btn-primary margin-r-5">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filter') }}
                </button>
                <span data-toggle="collapse" data-target="#datagrid-filters">
                    <i class="fa-solid fa-chevron-up"></i>
                </span>
            </span>

            <br class="clear" />
        </div>
        {!! Form::close() !!}
    </div>
</div>
