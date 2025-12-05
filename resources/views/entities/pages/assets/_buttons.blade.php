<a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::alias]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.alias') }}
</a>
<a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::file]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.file') }}
</a>
<a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::link]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.link') }}
</a>
