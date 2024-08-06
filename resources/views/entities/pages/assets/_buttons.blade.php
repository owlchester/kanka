<a href="#" class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Models\EntityAsset::TYPE_ALIAS]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.alias') }}
</a>
<a href="#" class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Models\EntityAsset::TYPE_FILE]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.file') }}
</a>
<a href="#" class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="asset-dialog" data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Models\EntityAsset::TYPE_LINK]) }}">
    <x-icon class="plus" /> {{ __('entities/assets.actions.link') }}
</a>
