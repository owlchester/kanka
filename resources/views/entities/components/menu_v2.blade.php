<div class="entity-submenu md:w-52 md:flex-none">
    @includeWhen(isset($withPins), 'entities.components.pins')
    @include('entities.components.menu')
    @includeWhen(!isset($withPins), 'ads.siderail_left')
</div>
