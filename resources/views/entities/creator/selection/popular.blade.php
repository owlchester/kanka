<div class="text-uppercase text-sm font-bold mb-4">
    {{ __('entities.creator.titles.quick-access') }}
</div>
<div class="selection flex flex-col gap-4">
    @foreach ($popular as $key)
        @includeWhen(isset($entities[$key]), 'entities.creator.selection._' . $key)
    @endforeach
</div>
