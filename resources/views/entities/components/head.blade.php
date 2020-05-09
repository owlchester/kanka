<?php /** @var \App\Models\MiscModel $model */?>

@if (!View::hasSection('entity-header'))
<div class="entity-menu-head">
    @if ($model->image)
        <a href="{{ $model->getImageUrl(0) }}" title="{{ $model->name }}" target="_blank">
            <img src="{{ $model->getImageUrl(0)  }}" alt="{{ $model->name }} picture">
        </a>
    @endif

    <h3>{{ $model->name }}
        @if ($model->is_private)
            <i class="fas fa-lock" title="{{ __('crud.is_private') }}"></i>
        @endif
    </h3>
@endif
</div>
