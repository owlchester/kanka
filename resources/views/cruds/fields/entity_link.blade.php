<?php /** @var \App\Models\Entity $entity */?>
@if ($entity)
    <div class="entity">
        <label>{{ __('crud.fields.entity') }}</label><br />
        {!! $entity->tooltipedLink(null, true, 'data-placement="bottom"') !!}
    </div>
@endif
