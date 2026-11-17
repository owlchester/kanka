@php
    $statusEntityType = $entityType ?? $entity->entityType ?? null;
    $categoryStatuses = $statusEntityType
        ? \App\Models\CategoryStatus::inCampaign($campaign)->where('category_id', $statusEntityType->id)->orderBy('sort_order')->get()
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
        } elseif ($statusEntityType->isCustom() || !$hasDefault) {
            $statusOptions[''] = $statusEntityType->isCustom() ? __('No status') : '';
        }
        foreach ($categoryStatuses as $catStatus) {
            $statusOptions[$catStatus->id] = e($catStatus->setRelation('entityType', $statusEntityType)->name());
        }
        $defaultStatus = $hasDefault ? $categoryStatuses->firstWhere('is_default', true)->id : '';
        $selectedStatus = $isBulk ? '' : old('status_id', $statusEntityType->isCustom()
            ? (isset($source) ? $source->status_id : (isset($entity) && $entity->exists ? $entity->status_id : ($campaign->premium() ? $defaultStatus : '')))
            : ($source->status_id ?? $entity->status_id ?? $defaultStatus));
        if ($statusEntityType->isCustom() && !$campaign->premium()) {
            $statusOptions = array_intersect_key($statusOptions, array_flip($isBulk ? ['', 'remove'] : ['', (string) $selectedStatus]));
        }
    @endphp
    <x-forms.field field="status_id" :label="__('entities.status')">
        <x-forms.select name="status_id" :options="$statusOptions" :selected="$selectedStatus" />
    </x-forms.field>
@endif
