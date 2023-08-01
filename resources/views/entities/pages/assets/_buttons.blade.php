<a href="#" class="btn2 btn-accent btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_ALIAS]) }}">
    <x-icon class="plus"></x-icon> {{ __('entities/assets.actions.alias') }}
</a>
<a href="#" class="btn2 btn-accent btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_FILE]) }}">
    <x-icon class="plus"></x-icon> {{ __('entities/assets.actions.file') }}
</a>
<a href="#" class="btn2 btn-accent btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_LINK]) }}">
    <x-icon class="plus"></x-icon> {{ __('entities/assets.actions.link') }}
</a>
