<?php /** @var \App\Models\Calendar $model */ ?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')

<div class="entity-submenu">
    @if (isset($withPins))
        @include('entities.components.pins')
    @endif
    @include('entities.components.menu')
</div>
