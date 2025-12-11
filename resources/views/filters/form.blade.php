@php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\EntityType $entityType
 * @var \App\Services\FilterService $filterService
 */
    use Illuminate\Support\Arr;

    if (isset($entityType) && $entityType->isCustom()) {
        $formRoute = ['entities.index', $campaign, $entityType];
        $resetRoute = route('entities.index', [$campaign, $entityType, 'reset-filter' => 'true']);
    } else {
        $formRoute = [$route, $campaign, 'm' => $mode];
        $resetRoute = route($route, [$campaign, 'reset-filter' => 'true']);
    }
@endphp
<x-form :action="$formRoute" method="GET" id="crud-filters-form" class="block">
<x-dialog.header>
    {{ __('crud.filters.title') }}
</x-dialog.header>
<x-dialog.article>
    @if (auth()->guest())
        <x-helper>
            <p>{{ __('filters.helpers.guest') }}</p>
        </x-helper>
    @else
        <x-grid class="max-w-3xl">
            @foreach ($filters as $field)

                @if ($field === 'attributes')
                    @php $hasAttributeFilters = true @endphp
                    @continue
                @elseif ($field === 'connections')
                    @php $hasConnectionFilters = true @endphp
                    @continue
                @endif
                <div class="field flex flex-col gap-1 field-{{ $field['field'] ?? 'unknown' }}">
                    @if (is_array($field))
                        <label>{!! Arr::get($field, 'label', __('crud.fields.' . $field['field'])) !!}</label>
                            <?php
                            $model = $models = null;
                            $value = $filterService->single($field['field']);
                            if (!empty($value) && $field['type'] == 'select2') {
                                $modelclass = new $field['model'];
                                $model = $modelclass->find($value);
                            }
                            // Support for fields with multiple models selected
                            if (Arr::get($field, 'multiple') === true && $field['type'] == 'selectMultiple') {
                                $value = $filterService->filterValue($field['field']);
                                if (!empty($value)) {
                                    $modelclass = new $field['model'];
                                    $models = $modelclass->whereIn('id', $value)->get()->pluck('name', 'id')->toArray();
                                }
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
                        <label>
                            {{ __($field === 'is_dead' ? 'characters.fields.' . $field : ((in_array($field, ['name', 'type', 'is_private', 'has_image', 'has_attributes', 'has_entity_files', 'has_entry', 'has_posts', 'date_range', 'template', 'archived']) ? 'crud.fields.' : $langKey . '.fields.') . $field)) }}
                        </label>
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
                        @elseif ($field === 'archived')
                            @include('cruds.datagrids.filters._archived')
                        @else
                            <input type="text" class="w-full entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" data-1p-ignore="true" />
                        @endif
                    @endif
                </div>
            @endforeach
        </x-grid>
        @includeWhen($hasAttributeFilters, 'cruds.datagrids.filters._attributes')
        @includeWhen(isset($hasConnectionFilters), 'cruds.datagrids.filters._connection')
@endif
<br class="clear-both" />
</x-dialog.article>
@if (auth()->check())
    <footer class="flex flex-wrap gap-3 justify-between items-start p-3">
        <menu class="flex flex-wrap gap-3 ps-0">
            <span role="button" class="flex-none btn2 btn-sm flex gap-2 items-center {{ $filterService->activeFiltersCount() === 0 ? 'btn-disabled' : null }} "
               @if ($filterService->activeFiltersCount() > 0) data-clipboard="{{ $filterService->clipboardFilters() }}" data-toast="{{ __('filters.alerts.copy') }}" onclick="return false"  @endif data-toggle="tooltip" data-title="{{ __('crud.filters.copy_helper') }}">
                <x-icon class="fa-solid fa-clipboard" />
                <span class="max-sm:hidden">{{ __('crud.filters.copy_to_clipboard') }}</span>
                <span class="visible md:hidden">{{ __('crud.filters.mobile.copy') }}</span>
            </span>

            @if ($filterService->activeFiltersCount() > 0)
                <a href="{{ $resetRoute }}" class="btn2 btn-sm btn-error btn-outline">
                    <x-icon class="fa-regular fa-eraser" />
                    {{ __('crud.filters.mobile.clear') }}
                </a>
            @endif

            <a class="btn2 btn-sm btn-link" href="//docs.kanka.io/en/latest/advanced/filters.html" target="_blank" title="{{ __('helpers.filters.title') }}">
                {{ __('helpers.filters.title') }}
            </a>
        </menu>
        <menu class="flex flex-wrap gap-3 ps-0">
            <button type="submit" class="btn2 btn-primary btn-sm">
                <x-icon class="fa-solid fa-filter" />
                {{ __('crud.filter') }}
            </button>
        </menu>
    </footer>
@endif
    @if (isset($entityType) && $entityType->isStandard())
<input type="hidden" name="m" value="{{ $mode }}" />
    @endif
</x-form>
