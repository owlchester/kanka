<a href="#" class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::ALIAS->value]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.alias') }}
</a>
<a href="#" class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::FILE->value]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.file') }}
</a>
<a href="#" class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::LINK->value]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.link') }}
</a>
