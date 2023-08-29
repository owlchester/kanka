
<div class="grid gap-2 md:gap-4 grid-cols-1 sm:grid-cols-2">
    <input type="date" class="w-full entity-list-filter" name="date_start" value="{{ $filterService->single('date_start') }}" />
    <input type="date" class="w-full entity-list-filter" name="date_end" value="{{ $filterService->single('date_end') }}" />
</div>
