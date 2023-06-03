
<div class="grid gap-5 grid-cols-1 sm:grid-cols-2 mb-4">
    <input type="date" class="form-control entity-list-filter" name="date_start" value="{{ $filterService->single('date_start') }}" />
    <input type="date" class="form-control entity-list-filter" name="date_end" value="{{ $filterService->single('date_end') }}" />
</div>
