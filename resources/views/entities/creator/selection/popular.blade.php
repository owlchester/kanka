<div class="text-uppercase text-xs font-bold mb-2">
    {{ __('entities.creator.titles.quick-access') }}
</div>
<div class="selection">
    @foreach ($popular as $key)
        @includeWhen(isset($entities[$key]), 'entities.creator.selection._' . $key)
    @endforeach
</div>
