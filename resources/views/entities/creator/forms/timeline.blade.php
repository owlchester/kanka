

<div class="grid grid-cols-2 gap-5">
    @include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'timelines'])

    @include('cruds.fields.timeline', ['isParent' => true, 'dynamicNew' => true])
</div>
