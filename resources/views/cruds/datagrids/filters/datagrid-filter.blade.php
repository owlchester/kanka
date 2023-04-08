@php
/**
 * @var \App\Datagrids\Filters\DatagridFilter $filter
 * @var \App\Services\FilterService $filterService
 */
use Illuminate\Support\Arr;
$filters = $filter->filters();
//$highlights = $filter->highlighted();
$activeFilters = $filterService->activeFiltersCount();
$entityModel = $model;
$count = 0;
$clipboardFilters = $filterService->clipboardFilters();
$hasAttributeFilters = false;

@endphp

@if (auth()->guest())
    <div class="text-muted grow">{{ __('filters.helpers.guest') }}</div>
    <?php return; ?>
@endif

<div class="grow flex gap-2">
    <div class="inline-block cursor-pointer btn btn-default" data-toggle="dialog" data-target="datagrid-filters">
        <i class="fa-solid fa-filter" aria-hidden="true"></i> {{ __('crud.filters.title') }}
        @if ($activeFilters > 0)
            <span class="label label-danger">{{ $activeFilters }}</span>
        @endif
    </div>

    @if ($activeFilters > 0)
        <a href="{{ route($route, ['reset-filter' => 'true']) }}" class="p-1.5">
            <i class="fa-solid fa-eraser" aria-hidden="true"></i> {{ __('crud.filters.clear') }}
        </a>
    @endif
</div>

@section('modals')
    @parent()
    <x-dialog id="datagrid-filters" title="{{ __('crud.filters.title') }}" full="true">
        {!! Form::open(['url' => route($route), 'method' => 'GET', 'id' => 'crud-filters-form']) !!}
            @if (auth()->guest())
                <p class="help-block">{{ __('filters.helpers.guest') }}</p>
            @else
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 md:gap-5 mb-5 max-w-3xl">
                    @foreach ($filters as $field)
                        @php $count++ @endphp

                        @if ($field === 'attributes')
                            @php $hasAttributeFilters = true @endphp
                            @continue
                        @endif
                        <div class="form-group m-0">
                            @if (is_array($field))
                                <label>{{ Arr::get($field, 'label', __('crud.fields.' . $field['field'])) }}</label>
                                <?php $model = null;
                                $value = $filterService->single($field['field']);
                                if (!empty($value) && $field['type'] == 'select2') {
                                    $modelclass = new $field['model'];
                                    $model = $modelclass->find($value);
                                }
                                ?>
                                @if ($field['type'] === 'tag')
                                    @include('cruds.datagrids.filters._tag', ['value' => $filterService->filterValue('tags')])
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
                    @endforeach
                </div>
                @includeWhen($hasAttributeFilters, 'cruds.datagrids.filters._attributes')
            @endif
            <br class="clear-both" />
            <hr />
            <div class="flex items-center gap-2 md:gap-5">
                @if (auth()->check())
                    <a href="#" class="flex-0 btn btn-default flex gap-2 items-center"
                       @if ($activeFilters > 0) data-clipboard="{{ $clipboardFilters }}" data-toast="{{ __('filters.alerts.copy') }}" onclick="return false" @else disabled @endif data-toggle="tooltip" title="{{ __('crud.filters.copy_helper') }}">
                        <i class="fa-solid fa-clipboard" aria-hidden="true"></i>
                        <span class="max-sm:hidden">{{ __('crud.filters.copy_to_clipboard') }}</span>
                        <span class="visible md:hidden">{{ __('crud.filters.mobile.copy') }}</span>
                    </a>

                    <a class="grow" href="//docs.kanka.io/en/latest/advanced/filters.html" target="_blank" title="{{ __('helpers.filters.title') }}">
                        <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                        {{ __('helpers.filters.title') }}
                    </a>

                    @if ($activeFilters > 0)
                        <a href="{{ route($route, ['reset-filter' => 'true', 'm' => $mode]) }}" class="text-center">
                            <i class="fa-solid fa-eraser mr-1" aria-hidden="true"></i>
                            {{ __('crud.filters.mobile.clear') }}
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary flex-0">
                        <i class="fa-solid fa-filter" aria-hidden="true"></i>
                        {{ __('crud.filter') }}
                    </button>
                @endif
            </div>
        <input type="hidden" name="mode" value="{{ $mode }}" />
        {!! Form::close() !!}
    </x-dialog>
@endsection
