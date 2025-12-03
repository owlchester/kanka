<x-form method="GET" :action="$route" class="flex-0 w-fit! datagrid-search inline-block">
<div class="field field-search">
    <input type="text" name="search" value="{{ $filterService->search() ?? null }}" placeholder="{{ __('crud.search') }}" />
</div>
<input type="hidden" name="m" value="{{ $mode }}" />
</x-form>
