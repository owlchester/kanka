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

$addTagsUrl = route('entity.tags-add', [$campaign, $entity]);
$adminRole = \App\Facades\CampaignCache::adminRole();

/** @var \App\Models\Tag[] $entityTags */
$entityTags = $entity->visibleTags;

$buttonsClass = 1;
if ($entity->isCharacter() && $entity->child->is_dead) {
    $buttonsClass++;
}
if ($entity->isQuest() && $entity->child->is_completed) {
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
    $headerImageL = $entity->getHeaderUrl(2400, 800);
    $headerImageXL = $entity->getHeaderUrl(2400, 800);

}

?>
<div class="w-full h-full entity-header flex-wrap md:flex-no-wrap flex gap-2 md:gap-5 items-end relative @if ($hasBanner) with-entity-banner p-4 text-white aspect-[3/1] @endif">
    @if ($imageUrl)
    <div class="entity-header-image relative w-28 flex-none md:w-48 self-start md:self-auto z-10">

        @can('update', $entity)
            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $entity->name }}"/>
            @endif

            @if (!isset($printing))
            <a class="cursor-pointer relative cover-background sm:hidden" href="{{ $imageUrl }}" target="_blank" aria-label="Open original image">
                <img src="{{ $imagePathMobile }}" lazy alt="{{ $entity->name }}" class="w-28" />
            </a>
            @endif
            <div class="dropdown">
                <div class="cursor-pointer hidden sm:block print-none entity-picture relative {{ $imageClass }}" data-dropdown aria-expanded="false">
                    @if ($imageVisibility && $imageVisibility !== \App\Enums\Visibility::All)
                        <div class="absolute bottom-0 right-0 flex items-center justify-center w-6 h-6" data-toggle="tooltip" data-title="{{ __('entities/image.gallery_permissions.' . strtolower($entity->image->visibility_id->name), ['admin' => \Illuminate\Support\Arr::get($adminRole, 'name', __('campaigns.roles.admin_role')), 'creator' => $entity->image->creator?->name]) }}">
                            <x-icon :class="$entity->image->visibilityIcon()['class']" />
                        </div>
                    @endif
                    <picture>
                        <source media="(min-width:766px)" srcset="{{ $imagePathXL }}">
                        <img src="{{ $imagePath }}" alt="{{ $entity->name }}" style="width:auto;">
                    </picture>
                </div>

                <div class="dropdown-menu hidden" role="menu">
                    <x-dropdowns.item
                        :link="$imageUrl"
                        icon="link"
                        target="_blank">
                        {{ __('entities/image.actions.view') }}
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
            <a class="entity-image cover-background block rounded-none" href="{{ $imageUrl }}" target="_blank" style="background-image: url('{{ $imagePath }}');"></a>
            @endif
        @endcan
    </div>
    @endif
    <div class="entity-header-text grow flex flex-col gap-1 md:gap-2 z-10">
        @if (!empty($breadcrumb))
            <ol class="entity-breadcrumb text-sm m-0 p-0">
                @foreach ($breadcrumb as $bcdata)
                    <li class="inline-block">
                    @if (is_array($bcdata))
                    <a href="{{ $bcdata['url'] }}" class="no-underline text-neutral-content" title="{{ $bcdata['label'] }}">
                        {!! $bcdata['label'] !!}
                    </a>
                    @elseif(!empty($bcdata))
                        {!! $bcdata !!}
                    @endif
                    </li>
                @endforeach
            </ol>
        @endif
        <div class="entity-name-header flex gap-3 items-center">
            <h1 class="entity-name text-lg md:text-4xl break-all">
                {!! $entity->name !!}
            </h1>
            @if ($entity->isCharacter() && $entity->child->isDead())
                <span class="entity-name-icon entity-char-dead md:text-2xl" data-toggle="tooltip" data-title="{{ __('characters.hints.is_dead') }}">
                    <x-icon class="fa-regular fa-skull entity-icons" />
                    <span class="sr-only">{{ __('characters.hints.is_dead') }}</span>
                </span>
            @endif
            @if ($entity->isQuest() && $entity->child->isCompleted())
                <span class="entity-name-icon entity-quest-complete md:text-2xl" data-toggle="tooltip" data-title="{{ __('quests.fields.is_completed') }}">
                    <x-icon class="fa-regular fa-check-circle entity-icons" />
                    <span class="sr-only">{{ __('quests.fields.is_completed') }}</span>
                </span>
            @endif
            @if ($entity->isOrganisation() && $entity->child->isDefunct())
                <span class="entity-name-icon entity-org-defunct md:text-2xl" data-toggle="tooltip" data-title="{{ __('organisations.hints.is_defunct') }}">
                    <x-icon class="fa-regular fa-shop-slash entity-icons " />
                    <span class="sr-only">{{ __('organisations.hints.is_defunct') }}</span>
                </span>
            @endif
            @if ($entity->isLocation() && $entity->child->isDestroyed())
                <span class="entity-name-icon entity-loc-destroyed md:text-2xl" data-toggle="tooltip" data-title="{{ __('locations.hints.is_destroyed') }}">
                    <x-icon class="fa-regular fa-building-circle-xmark " />
                    <span class="sr-only">{{ __('locations.hints.is_destroyed') }}</span>
                </span>
            @endif
            @if ($entity->isRace() && $entity->child->isExtinct())
                <span class="entity-name-icon entity-rac-extinct md:text-2xl" data-toggle="tooltip" data-title="{{ __('races.hints.is_extinct') }}">
                    <x-icon class="fa-regular fa-skull-cow entity-icons " />
                    <span class="sr-only">{{ __('races.hints.is_extinct') }}</span>
                </span>
            @endif
            @if ($entity->isCreature() && $entity->child->isExtinct())
                <span class="entity-name-icon entity-cre-extinct md:text-2xl" data-toggle="tooltip" data-title="{{ __('creatures.hints.is_extinct') }}">
                    <x-icon class="fa-regular fa-skull-cow entity-icons " />
                    <span class="sr-only">{{ __('creatures.hints.is_extinct') }}</span>
                </span>
            @endif
            @if ($entity->isCreature() && $entity->child->isDead())
                <span class="entity-name-icon entity-cre-dead md:text-2xl" data-toggle="tooltip" data-title="{{ __('creatures.hints.is_dead') }}">
                    <x-icon class="fa-regular fa-skull entity-icons " />
                    <span class="sr-only">{{ __('creatures.hints.is_dead') }}</span>
                </span>
            @endif
            @if ($entity->isFamily() && $entity->child->isExtinct())
                <span class="entity-name-icon entity-fam-extinct md:text-2xl" data-toggle="tooltip" data-title="{{ __('families.hints.is_extinct') }}">
                    <x-icon class="fa-regular fa-skull entity-icons " />
                    <span class="sr-only">{{ __('families.hints.is_extinct') }}</span>
                </span>
            @endif
            @can('admin', $campaign)
                <span role="button" tabindex="0" class="entity-privacy-icon md:text-2xl" data-toggle="dialog" data-url="{{ route('entities.quick-privacy', [$campaign, $entity]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <i class="fa-regular fa-lock entity-icons" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        <i class="fa-regular fa-lock-open entity-icons" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
                    </span>
            @endif
        </div>

        @if ($entity->isCharacter()&& !empty($entity->child->title))
            <div class="entity-title entity-header-line">
                {!! $entity->child->title !!}
            </div>
        @endif

        @if (!$entity->entityType->isSpecial() && !empty($entity->child->type))
            <div class="entity-type entity-header-line">
                {{ $entity->child->type }}
            </div>
        @endif

        <div class="entity-tags entity-header-line text-xs">
            <div class="flex flex-wrap gap-2 items-center">
        @if($entityTags->count() > 0)
            @foreach ($entityTags as $tag)
                @if (!$tag->entity) @continue @endif
                <a href="{{ route('tags.show', [$campaign, $tag]) }}" data-toggle="tooltip-ajax"
                   data-id="{{ $tag->entity->id }}" data-url="{{ route('entities.tooltip', [$campaign, $tag->entity->id]) }}"
                   data-tag-slug="{{ $tag->slug }}"
                >
                    @include ('tags._badge')
                </a>
            @endforeach
        @endif
            @can('update', $entity)
                <span role="button" tabindex="0" class="entity-tag-icon text-xl" data-toggle="dialog" data-url="{{ $addTagsUrl }}" data-target="primary-dialog" aria-haspopup="dialog">
                    <x-icon class="fa-regular fa-tag" tooltip="1" :title="__('entities/tags.create.title')" />
                    <span class="sr-only">{{ __('entities/tags.create.title')  }}</span>
                </span>
            @endcan
            </div>
        </div>

        <div class="entity-header-sub flex gap-4 items-center flex-wrap">
            @if ($entity->entityType->isSpecial())
                @includeIf('entities.headers._custom')
            @endif
            @includeIf('entities.headers._' . $entity->entityType->code)
        </div>

        @yield($entityHeaderActions ?? 'entity-header-actions')
    </div>

    @if ($hasBanner && $entity->header && $entity->header->visibility_id !== \App\Enums\Visibility::All)
        @php
            $headerHelper = __('entities/image.gallery_permissions.' . strtolower($entity->header->visibility_id->name), ['admin' => \Illuminate\Support\Arr::get($adminRole, 'name', __('campaigns.roles.admin_role')), 'creator' => $entity->header->creator?->name]);
        @endphp
        @can('visibility', $entity->header)
        <span
            role="button"
            tabindex="0"
            class="header-visibility absolute top-2 right-2 rounded cursor-pointer z-10"
            data-toggle="dialog"
            data-url="{{ route('gallery.file.visibility', [$campaign, $entity->header]) }}"
            data-target="primary-dialog"
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
            <picture class="entity-banner absolute top-0 left-0 -z-10 w-full aspect-[3/1]">
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
