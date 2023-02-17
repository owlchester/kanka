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
    <div class="box-header cursor-pointer" data-toggle="collapse" data-target="#datagrid-filters">

        <i class="fa-solid fa-chevron-down pull-right"></i>
        <i class="fa-solid fa-filter"></i> {{ __('crud.filters.title') }}

        @if ($activeFilters > 0)
            <span class="label label-danger">{{ $activeFilters }}</span>
            <div class="box-tools">
                <a href="{{ route($route, ['campaign' => $campaign->id, 'reset-filter' => 'true']) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-eraser"></i> {{ __('crud.filters.clear') }}
                </a>
            </div>
        @endif
    </div>

    {!! Form::open(['url' => route($route, ['campaign' => $campaign->id]), 'method' => 'GET', 'id' => 'crud-filters-form']) !!}
    <div class="collapse out" id="datagrid-filters">
        <div class="box-body">
            @if (auth()->guest())
                <p class="help-block">{{ __('filters.helpers.guest') }}</p>
            @else
            <div class="row">
                @foreach ($filters as $field)
                    @if ($count % 2 === 0 || (is_string($field) && $field == 'attributes'))
                </div>
                <div class="row">
                    @endif
                    @php $count++ @endphp

                    @if ($field === 'attributes')
                        @include('cruds.datagrids.filters._attributes')
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
                                @if ($field['type'] === 'tag')
                                    @include('cruds.datagrids.filters._tag')
                                @elseif ($field['type'] === 'select')
                                    @include('cruds.datagrids.filters._select')
                                @else
                                    @include('cruds.datagrids.filters._array')
                                @endif
                            @else
                                <label>{{ __((in_array($field, ['name', 'type', 'is_private', 'has_image', 'has_attributes', 'has_entity_files', 'has_posts', 'date_range', 'template']) ? 'crud.fields.' : $langKey . '.fields.') . $field) }}</label>
                                @if ($filterService->isCheckbox($field))
                                    @include('cruds.datagrids.filters._choice')
                                @elseif ($field === 'type' && !empty($entityModel))
                                    @include('cruds.datagrids.filters._type')
                                @elseif ($field === 'sex' && !empty($entityModel))
                                    @include('cruds.datagrids.filters._sex')
                                @elseif ($field === 'date')
                                    @include('cruds.datagrids.filters._date')
                                @elseif ($field === 'element_role')
                                    @include('cruds.datagrids.filters._element-role')
                                @elseif ($field === 'date_range')
                                    @include('cruds.datagrids.filters._date-range')
                                @elseif ($field === 'template')
                                    @include('cruds.datagrids.filters._template')
                                @else
                                    <input type="text" class="form-control entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" />
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="box-footer text-center">
            <div class="pull-left hidden-xs">
                <a href="{{ route($route, ['campaign' => $campaign->id, 'reset-filter' => 'true']) }}" class="btn btn-default">
                    <i class="fa-solid fa-eraser"></i> {{ __('crud.filters.clear') }}
                </a>

                @if (auth()->check())
                    @if ($activeFilters > 0)
                    <a href="#" class="btn btn-default mr-2" data-clipboard="{{ $clipboardFilters }}" data-toggle="tooltip" title="{{ __('crud.filters.copy_helper') }}" data-toast="{{ __('filters.alerts.copy') }}">
                        <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.copy_to_clipboard') }}
                    </a>
                    @else
                        <div class="visible-lg-inline-block visible-md-inline-block visible-sm-inline-block mr-2" data-toggle="tooltip" title="{{ __('crud.filters.copy_helper_no_filters') }}">
                        <a href="#" class="btn btn-default cursor-none" disabled >
                            <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.copy_to_clipboard') }}
                        </a>
                        </div>
                    @endif

                    <a href="//docs.kanka.io/en/latest/advanced/filters.html" target="_blank" title="{{ __('helpers.filters.title') }}">
                        {{ __('helpers.filters.title') }} <i class="fa-solid fa-question-circle"></i>
                    </a>
                @endif
            </div>

            <div class="visible-xs pull-left block">
                <a href="{{ route($route, ['campaign' => $campaign->id, 'reset-filter' => 'true']) }}" class="btn btn-default mr-2">
                    <i class="fa-solid fa-eraser"></i> {{ __('crud.filters.mobile.clear') }}
                </a>

                @if (auth()->check())
                    @if ($activeFilters > 0)
                    <a href="#" class="btn btn-default mr-2" data-clipboard="{{ $clipboardFilters }}" data-toggle="tooltip">
                        <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.mobile.copy') }}
                    </a>
                    @else
                    <a href="#" class="btn btn-default mr-2" disabled="disabled" data-toggle="tooltip" title="{{ __('crud.filters.copy_helper_no_filters') }}">
                        <i class="fa-solid fa-clipboard"></i> {{ __('crud.filters.mobile.copy') }}
                    </a>
                    @endif

                    <a href="//docs.kanka.io/en/latest/advanced/filters.html" target="_blank" title="{{ __('helpers.filters.title') }}">
                        <i class="fa-solid fa-question-circle"></i>
                    </a>
                @endif
            </div>

            @if (auth()->check())
            <span class="pull-right">
                <button type="submit" class="btn btn-primary mr-2">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filter') }}
                </button>
                <span data-toggle="collapse" data-target="#datagrid-filters">
                    <i class="fa-solid fa-chevron-up"></i>
                </span>
            </span>
            @endif

            <br class="clear-both" />
        </div>
    </div>
    {!! Form::close() !!}
</div>
