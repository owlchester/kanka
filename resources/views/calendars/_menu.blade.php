<?php /** @var \App\Models\Calendar $model */ ?>

<div class="entity-submenu">
    @if (isset($withPins))
        @include('entities.components.pins')
    @endif
    @include('entities.components.menu')
</div>
