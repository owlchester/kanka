<div class="text-uppercase text-sm font-bold mb-4">
    {{ __('entities.creator.titles.quick-access') }}
</div>
<div class="selection flex flex-col gap-4 pr-4">
    @foreach ($popular as $entityType)
        <div class="option flex justify-between gap-1">
            @include('entities.creator.selection._main')
            @include('entities.creator.selection._full')
        </div>
    @endforeach
</div>
