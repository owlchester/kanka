@php
    /**
     * @var \App\Models\Campaign $campaign
     * @var \App\Models\EntityType $entityType
     * @var \App\Services\FilterService $filterService
     */
    use Illuminate\Support\Arr;
@endphp
<x-form :action="['entities.index', $campaign, $entityType]" method="GET" id="crud-filters-form" class="block">
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

                <div class="field flex flex-col gap-1 field-name">
                    <label>{!! __('crud.fields.name') !!}</label>
                    <input type="text" class="w-full entity-list-filter" name="name" value="{{ $filterService->single('name') }}" data-1p-ignore="true" />
                </div>
                <div class="field flex flex-col gap-1 field-locations">
                    <label>{!! __('crud.fields.type') !!}</label>
                    @include('cruds.datagrids.filters._type', ['field' => 'type'])
                </div>
                <div class="field flex flex-col gap-1 field-type">
                    <label>{{ \App\Facades\Module::singular(config('entities.ids.location'), __('entities.location')) }}</label>
                    @include('cruds.datagrids.filters._array', ['field' => ['id' => uniqid('locations_'), 'field' => 'locations', 'data' => []], 'value' => $filterService->filterValue('locations')])
                </div>

                <div class="field flex flex-col gap-1 field-is_private">
                    <label>{!! __('crud.fields.is_private') !!}</label>
                    @include('cruds.datagrids.filters._choice', ['field' => 'is_private'])
                </div>
                <div class="field flex flex-col gap-1 field-has_image">
                    <label>{!! __('crud.fields.has_image') !!}</label>
                    @include('cruds.datagrids.filters._choice', ['field' => 'has_image'])
                </div>
                <div class="field flex flex-col gap-1 field-has_entity_files">
                    <label>{!! __('crud.fields.has_entity_files') !!}</label>
                    @include('cruds.datagrids.filters._choice', ['field' => 'has_entity_files'])
                </div>
                <div class="field flex flex-col gap-1 field-has_entry">
                    <label>{!! __('crud.fields.has_entry') !!}</label>
                    @include('cruds.datagrids.filters._choice', ['field' => 'has_entry'])
                </div>
                <div class="field flex flex-col gap-1 field-has_posts">
                    <label>{!! __('crud.fields.has_posts') !!}</label>
                    @include('cruds.datagrids.filters._choice', ['field' => 'has_posts'])
                </div>
                <div class="field flex flex-col gap-1 field-template">
                    <label>{!! __('crud.fields.template') !!}</label>
                    @include('cruds.datagrids.filters._choice', ['field' => 'template'])
                </div>
                <div class="field flex flex-col gap-1 field-archived">
                    <label>{!! __('crud.fields.archived') !!}</label>
                    @include('cruds.datagrids.filters._archived', ['field' => 'archived'])
                </div>
                <div class="field flex flex-col gap-1 field-tags">
                    <label>{!! __('entities.tags') !!}</label>
                    @include('cruds.datagrids.filters._tag', ['value' => $filterService->filterValue('tags'), 'field' => ['field' => 'tags']])
                </div>
            </x-grid>
            @include('cruds.datagrids.filters._attributes')
        @endif
        <br class="clear-both" />
    </x-dialog.article>
    @if (auth()->check())
        <footer class="flex flex-wrap gap-3 justify-between items-start p-3">
            <menu class="flex flex-wrap gap-3 ps-0">
            <span role="button" class="flex-none btn2 btn-sm flex gap-2 items-center {{ $filterService->activeFiltersCount() === 0 ? 'btn-disabled' : null }} "
                  @if ($filterService->activeFiltersCount() > 0) data-clipboard="{{ $filterService->clipboardFilters() }}" data-toast="{{ __('filters.alerts.copy') }}" onclick="return false"  @endif data-toggle="tooltip" data-title="{{ __('crud.filters.copy_helper') }}">
                <x-icon class="fa-regular fa-clipboard" />
                <span class="max-sm:hidden">{{ __('crud.filters.copy_to_clipboard') }}</span>
                <span class="visible md:hidden">{{ __('crud.filters.mobile.copy') }}</span>
            </span>

                @if ($filterService->activeFiltersCount() > 0)
                    <a href="{{ route('entities.index', [$campaign, $entityType, 'reset-filter' => 'true']) }}" class="btn2 btn-sm btn-error btn-outline">
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
                    <x-icon class="fa-regular fa-filter" />
                    {{ __('crud.filter') }}
                </button>
            </menu>
        </footer>
    @endif
</x-form>
