<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 * @var \App\Models\Tag $tag
 */

$imageUrl = $imagePath = $headerImageUrl = $imagePathXL = $imagePathMobile = null;
$imageUrl = Avatar::entity($entity)->original();
$imagePath = Avatar::entity($entity)->size(192)->thumbnail();
$imagePathXL = Avatar::entity($entity)->size(400)->thumbnail();
$imagePathMobile = Avatar::entity($entity)->size(192)->thumbnail();
$imageVisibility = $entity->image ? $entity->image->visibility_id : null;
$imageClass = (!empty($imageVisibility) ? 'visibility-' . strtolower($imageVisibility->name) : null);
$entityType = $entityType ?? $entity->entityType;

$addTagsUrl = route('entity.tags-add', [$campaign, $entity]);

/** @var \App\Models\Tag[] $entityTags */
$entityTags = $entity->visibleTags();

$buttonsClass = 1;
$headerStatus = $entity->status;
if ($headerStatus && $headerStatus->icon) {
    $buttonsClass++;
}
if (auth()->check() && auth()->user()->isAdmin()) {
    $buttonsClass ++;
}

$hasBanner = false;
if($campaign->boosted() && $entity->hasHeaderImage()) {
    $hasBanner = true;
    $headerImageUrl = $entity->getHeaderUrl();
    $headerImageSquare = $entity->getHeaderUrl(400, 400);
    $headerImageS = $entity->getHeaderUrl(800, 267);
    $headerImageM = $entity->getHeaderUrl(1200, 400);
    $headerImageL = $entity->getHeaderUrl(1800, 400);
    $headerImageXL = $entity->getHeaderUrl(2400, 400);

}

$breadcrumb = Breadcrumb::campaign($campaign)->entity($entity)->list();

?>
<div class="w-full h-full entity-header flex-wrap md:flex-no-wrap flex gap-2 md:gap-5 items-end relative @if ($hasBanner) with-entity-banner p-4 text-white aspect-3/1 xl:aspect-auto @endif">
    @if ($imageUrl)
    <div class="entity-header-image relative w-28 flex-none md:w-48 self-start md:self-auto z-10">

        @can('update', $entity)
            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $entity->name }}"/>
            @endif

            @if (!isset($printing))
            <a class="cursor-pointer relative cover-background sm:hidden" href="{{ $imageUrl }}" target="_blank" aria-label="Open original image">
                <img src="{{ $imagePathMobile }}" loading="lazy" alt="{{ $entity->name }}" class="w-28 " />
            </a>
            @endif
            <div class="dropdown">
                <div class="cursor-pointer hidden sm:block print-none entity-picture relative {{ $imageClass }}" data-dropdown aria-expanded="false">
                    @if ($imageVisibility && $imageVisibility !== \App\Enums\Visibility::All)
                        <div class="absolute bottom-0 right-0 flex items-center justify-center w-6 h-6" data-toggle="tooltip" data-title="{{ __('entities/image.gallery_permissions.' . strtolower($entity->image->visibility_id->name), ['admin' => $campaign->adminRoleName(), 'creator' => $entity->image->creator?->name]) }}">
                            <x-icon :class="$entity->image->visibilityIcon()['class']" />
                        </div>
                    @endif
                    <picture class="">
                        <source media="(min-width:766px)" srcset="{{ $imagePathXL }}" class="">
                        <img src="{{ $imagePath }}" alt="{{ $entity->name }}" class="w-auto">
                    </picture>
                </div>

                <div class="dropdown-menu hidden" role="menu">
                    <x-dropdowns.item
                        :link="$imageUrl"
                        icon="link"
                        target="_blank">
                        {{ __('entities/image.actions.view') }}
                    </x-dropdowns.item>
                    <x-dropdowns.item
                        link="#"
                        icon="fa-regular fa-copy"
                        :data="['clipboard' => $imageUrl, 'toast' => __('entities/image.actions.copy_url_success')]">
                        {{ __('entities/image.actions.copy_url') }}
                    </x-dropdowns.item>
                    <x-dropdowns.divider />
                    <x-dropdowns.item
                        icon="fa-regular fa-shuffle"
                        :link="route('entities.image.replace', [$campaign, $entity])"
                        :dialog="route('entities.image.replace', [$campaign, $entity])">
                        {{ __('entities/image.actions.replace_image') }}
                    </x-dropdowns.item>

                    @if ($campaign->boosted())
                        <x-dropdowns.item
                            icon="fa-regular fa-crosshairs"
                            :link="route('entities.image.focus', [$campaign, $entity])">
                            {{ __('entities/image.actions.change_focus') }}</x-dropdowns.item>
                    @else
                        <x-dropdowns.item
                            link="#"
                            icon="fa-regular fa-crosshairs"
                            popup="booster-cta">
                            {{ __('entities/image.actions.change_focus') }}</x-dropdowns.item>
                    @endif

                    @if ($entity->image)
                    <x-dropdowns.item
                        icon="fa-regular fa-eye"
                        :link="route('gallery.file.visibility', [$campaign, $entity->image])"
                        :dialog="route('gallery.file.visibility', [$campaign, $entity->image])"
                        >
                        {{ __('entities/image.actions.change_visibility') }}</x-dropdowns.item>
                    @endif
                </div>
            </div>
        @else
            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $entity->name }}"/>
            @else
            <a class="entity-image block" href="{{ $imageUrl }}" target="_blank" >
                <picture class="">
                    <source media="(min-width:766px)" srcset="{{ $imagePathXL }}" class="">
                    <img src="{{ $imagePathMobile }}" alt="{{ $entity->name }}" loading="lazy" class="w-auto">
                </picture>
            </a>
            @endif
        @endcan
    </div>
    @endif
    <div class="entity-header-text grow flex flex-col gap-1 md:gap-2  z-10">
        <ol class="entity-breadcrumb text-sm m-0 p-0">
            <li class="inline-block">
                @if (!empty($bookmark))
                    <a href="{{ route('entities.index', [$campaign, $entity->entityType, 'bookmark' => $bookmark->id, '_from' => 'bookmark']) }}" class="" title="{{ $bookmark->name }}">
                        {!! $bookmark->name !!}
                    </a>
                @else
                    <a href="{{ $breadcrumb['url'] }}" class="" title="{{ $breadcrumb['label'] }}">
                        {!! $breadcrumb['label'] !!}
                    </a>
                @endif
            </li>
        </ol>
        <div class="entity-name-header flex gap-3 items-center">
            <h1 class="entity-name text-lg md:text-4xl break-all">
                {!! $entity->name !!}
            </h1>
            @if ($headerStatus && $headerStatus->icon)
                <span class="entity-name-icon md:text-2xl" data-toggle="tooltip" data-title="{{ __('entities/statuses.' . $entity->entityType->code . '.' . $headerStatus->key) }}">
                    <x-icon class="fa-regular {{ $headerStatus->icon }} entity-icons" />
                    <span class="sr-only">{{ __('entities/statuses.' . $entity->entityType->code . '.' . $headerStatus->key) }}</span>
                </span>
            @endif
            @can('admin', $campaign)
                <span role="button" tabindex="0" class="entity-privacy-icon md:text-2xl hover:text-primary" data-toggle="dialog" data-url="{{ route('entities.quick-privacy', [$campaign, $entity]) }}" aria-haspopup="dialog">
                        <i class="fa-regular fa-lock entity-icons" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        <i class="fa-regular fa-lock-open entity-icons" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
                    </span>
            @endif
        </div>

        @if (($entity->isCharacter() || $entity->isLocation()) && !empty($entity->child->title))
            <div class="entity-title entity-header-line">
                {!! $entity->child->title !!}
            </div>
        @endif

        <div class="entity-tags entity-header-line text-xs">
            <div class="flex flex-wrap gap-2 items-center">
        @if($entityTags->count() > 0)
            @foreach ($entityTags as $tag)
                @if (!$tag->entity) @continue @endif
                <a href="{{ route('entities.show', [$campaign, $tag->entity]) }}" data-toggle="tooltip-ajax"
                   data-id="{{ $tag->entity->id }}" data-url="{{ route('entities.tooltip', [$campaign, $tag->entity->id]) }}"
                   data-tag-slug="{{ $tag->slug }}"
                >
                    @include ('tags._badge')
                </a>
            @endforeach
        @endif
            @can('update', $entity)
                <span role="button" tabindex="0" class="entity-tag-icon text-xl hover:text-primary" data-toggle="dialog" data-url="{{ $addTagsUrl }}" aria-haspopup="dialog">
                    <x-icon class="fa-regular fa-tag" tooltip="1" :title="__('entities/tags.create.title')" />
                    <span class="sr-only">{{ __('entities/tags.create.title')  }}</span>
                </span>
            @endcan
            </div>
        </div>

        <div class="entity-header-sub flex gap-4 items-center flex-wrap">
            @if ($entity->entityType->isCustom())
                @includeIf('entities.headers._custom')
            @else
                @includeIf('entities.headers._' . $entity->entityType->code)
            @endif
        </div>

        @yield($entityHeaderActions ?? 'entity-header-actions')
    </div>

    @if ($hasBanner && $entity->header && $entity->header->visibility_id !== \App\Enums\Visibility::All)
        @php
            $headerHelper = __('entities/image.gallery_permissions.' . strtolower($entity->header->visibility_id->name), ['admin' => $campaign->adminRoleName(), 'creator' => $entity->header->creator?->name]);
        @endphp
        @can('visibility', $entity->header)
        <span
            role="button"
            tabindex="0"
            class="header-visibility absolute top-2 right-2 rounded cursor-pointer z-10"
            data-toggle="dialog"
            data-url="{{ route('gallery.file.visibility', [$campaign, $entity->header]) }}"
            aria-haspopup="dialog"
        >
            <x-icon :class="$entity->header->visibilityIcon()['class']" :title="$headerHelper" tooltip />
        </span>
        @else
            <span
                class="header-visibility absolute top-2 right-2 rounded z-10">
                <x-icon :class="$entity->header->visibilityIcon()['class']" :title="$headerHelper" tooltip />
            </span>
        @endcan
    @endif
        @if ($hasBanner)
            <picture class="entity-banner absolute top-0 left-0 w-full h-full">
                <source media="(min-width:2400px)" srcset="{{ $headerImageXL }}">
                <source media="(min-width:1600px)" srcset="{{ $headerImageL }}">
                <source media="(min-width:800px)" srcset="{{ $headerImageM }}">
                <source media="(min-width:600px)" srcset="{{ $headerImageS }}">
                <img
                    src="{{ $headerImageSquare }}"
                    alt="{{ $entity->name }} header image"
                    class="absolute inset-0 w-full h-full z-0 object-cover"
                >
            </picture>
        @endif
</div>

@section('modals')
    @parent

    @if (!$campaign->boosted())
        <x-dialog id="booster-cta" :title="__('callouts.booster.titles.boosted')">
            <p class="">{{ __('entities/image.call-to-action') }}</p>
            @can('boost', auth()->user())
            <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn2 bg-boost text-white btn-block">
                {!! __('callouts.premium.unlock', ['campaign' => $campaign->name]) !!}
            </a>
            @else
                <p class="">{{ __('callouts.booster.limitation') }}</p>
                <a href="{{ \App\Facades\Domain::toFront('premium')  }}" class="btn2 bg-boost text-white btn-block">
                    {!! __('callouts.premium.learn-more') !!}
                </a>
            @endif
        </x-dialog>
    @endif

    <x-dialog id="quick-privacy" :title="__('Loading')">
        <div class="p-5 text-center">
            <x-icon class="fa-solid fa-spinner fa-spin fa-2x" />
        </div>
    </x-dialog>
@endsection


@if ($entity->archived_at)
    <x-alert type="warning">
        <div class="flex items-center justify-between gap-4">
            <span>
                <x-icon class="fa-regular fa-archive" />
                {{ __('entries/archive.banner') }}
            </span>
            @can('update', $entity)
                <a href="{{ route('entities.archive', [$campaign, $entity]) }}" class="btn2 btn-sm btn-warning">
                    {{ __('entities/actions.unarchive.title') }}
                </a>
            @endcan
        </div>
    </x-alert>
@endif

@section('styles')
    @parent
    <style>
        /** Entity Images URL**/
        :root {
            @if ($imageUrl) --entity-image-url: url('{{ $imageUrl }}'); @endif
            @if ($headerImageUrl) --entity-header-image-url: url('{{ $headerImageUrl }}'); @endif
        }
    </style>
@endsection
