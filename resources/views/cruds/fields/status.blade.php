@php
    $statusEntityType = $entityType ?? $entity->entityType ?? null;
    $categoryStatuses = $statusEntityType
        ? \App\Models\CategoryStatus::where('category_id', $statusEntityType->id)->orderBy('sort_order')->get()
        : collect();
    $isBulk = $bulk ?? false;
@endphp
@if ($categoryStatuses->isNotEmpty())
    @php
        $hasDefault = $categoryStatuses->contains('is_default', true);
        $statusOptions = [];
        if ($isBulk) {
            $statusOptions[''] = '';
            $statusOptions['remove'] = __('entities/statuses.remove');
        } elseif (! $hasDefault) {
            $statusOptions[''] = '';
        }
        foreach ($categoryStatuses as $catStatus) {
            $statusOptions[$catStatus->id] = __('entities/statuses.' . $statusEntityType->code . '.' . $catStatus->key);
        }
        $selectedStatus = $isBulk ? '' : old('status_id', $source->status_id ?? $entity->status_id ?? ($hasDefault ? $categoryStatuses->firstWhere('is_default', true)->id : ''));
    @endphp
    <x-forms.field field="status_id" :label="__('entities.status')">
        <x-forms.select name="status_id" :options="$statusOptions" :selected="$selectedStatus" />
    </x-forms.field>
@endif
