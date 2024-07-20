<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 * @var \App\Models\Tag $tag
 */

if (!isset($entity)) {
    $entity = $model->entity;
}

$imageUrl = $imagePath = $headerImageUrl = $imagePathXL = $imagePathMobile = null;
$imageUrl = Avatar::entity($entity ?? $model->entity)->original();
$imagePath = Avatar::entity($entity ?? $model->entity)->size(192)->thumbnail();
$imagePathXL = Avatar::entity($entity ?? $model->entity)->size(400)->thumbnail();
$imagePathMobile = Avatar::entity($entity ?? $model->entity)->size(192)->thumbnail();

$addTagsUrl = route('entity.tags-add', [$campaign, $model->entity]);

/** @var \App\Models\Tag[] $entityTags */
$entityTags = $entity->tagsWithEntity();

$buttonsClass = 1;
if ($model instanceof \App\Models\Character && $model->is_dead) {
    $buttonsClass++;
}
if ($model instanceof \App\Models\Quest && $model->is_completed) {
    $buttonsClass++;
}
if (auth()->check() && auth()->user()->isAdmin()) {
    $buttonsClass ++;
}

$hasBanner = false;
if($campaign->boosted() && $entity->hasHeaderImage()) {
    $hasBanner = true;
    $headerImageUrl = $entity->getHeaderUrl();
}

?>

<div class="entity-header flex gap-5 items-end @if ($hasBanner) with-entity-banner p-4 text-white cover-background @endif" @if ($hasBanner) style="background-image: url('{{ $headerImageUrl }}');" @endif>

    @if ($imageUrl)
    <div class="entity-header-image relative w-28 flex-none md:w-48 self-start md:self-auto">

        @can('update', $model)
            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $model->name }}"/>
            @endif

            @if (!isset($printing))
            <a class="cursor-pointer relative cover-background sm:hidden" href="{{ $imageUrl }}" target="_blank" aria-label="Open original image">
                <img src="{{ $imagePathMobile }}" lazy alt="{{ $model->name }}" class=" w-28 " />

            </a>
            @endif
            <div class="dropdown">
                <div class="cursor-pointer hidden sm:block print-none" data-dropdown aria-expanded="false">
                    <picture>
                        <source media="(min-width:766px)" srcset="{{ $imagePathXL }}">
                        <img src="{{ $imagePath }}" alt="{{ $model->name }}" style="width:auto;">
                    </picture>
                </div>

                <div class="dropdown-menu hidden" role="menu">
                    <x-dropdowns.item
                        :link="$imageUrl"
                        target="_blank">
                        <x-icon class="fa-solid fa-external-link"></x-icon>
                        {{ __('entities/image.actions.view') }}
                    </x-dropdowns.item>
                    <hr class="m-0" />
                    <x-dropdowns.item
                        :link="route('entities.image.replace', [$campaign, $model->entity])"
                        :dialog="route('entities.image.replace', [$campaign, $model->entity])">
                        {{ __('entities/image.actions.replace_image') }}
                    </x-dropdowns.item>

                    @if ($campaign->boosted())
                        <x-dropdowns.item
                            :link="route('entities.image.focus', [$campaign, $model->entity])">
                            {{ __('entities/image.actions.change_focus') }}</x-dropdowns.item>
                    @else
                        <x-dropdowns.item
                            link="#"
                            popup="booster-cta">
                            {{ __('entities/image.actions.change_focus') }}</x-dropdowns.item>
                    @endif
                </div>
            </div>
        @else

            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $model->name }}"/>
            @else
            <a class="entity-image cover-background block rounded-none" href="{{ $imageUrl }}" target="_blank" style="background-image: url('{{ $imagePath }}');"></a>
            @endif
        @endcan
    </div>
    @endif
    <div class="entity-header-text grow flex flex-col gap-2">
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
                {!! $model->name !!}
            </h1>
            @if ($model instanceof \App\Models\Character && $model->isDead())
                <span class="entity-name-icon entity-char-dead cursor-pointer text-2xl" data-toggle="tooltip" data-title="{{ __('characters.hints.is_dead') }}">
                    <x-icon class="ra ra-skull entity-icons"></x-icon>
                    <span class="sr-only">{{ __('characters.hints.is_dead') }}</span>
                </span>
            @endif
            @if ($model instanceof \App\Models\Quest && $model->isCompleted())
                <span class="entity-name-icon entity-quest-complete cursor-pointer text-2xl" data-toggle="tooltip" data-title="{{ __('quests.fields.is_completed') }}">
                    <x-icon class="fa-solid fa-check-circle entity-icons"></x-icon>
                    <span class="sr-only">{{ __('quests.fields.is_completed') }}</span>
                </span>
            @endif
            @if ($model instanceof \App\Models\Organisation && $model->isDefunct())
                <span class="entity-name-icon entity-org-defunct cursor-pointer text-2xl" data-toggle="tooltip" data-title="{{ __('organisations.hints.is_defunct') }}">
                    <x-icon class="fa-solid fa-shop-slash entity-icons "></x-icon>
                    <span class="sr-only">{{ __('organisations.hints.is_defunct') }}</span>
                </span>
            @endif
            @if ($model instanceof \App\Models\Creature && $model->isExtinct())
                <span class="entity-name-icon entity-cre-extinct cursor-pointer text-2xl" data-toggle="tooltip" data-title="{{ __('creatures.hints.is_extinct') }}">
                    <x-icon class="fa-solid fa-skull-cow entity-icons "></x-icon>
                    <span class="sr-only">{{ __('creatures.hints.is_extinct') }}</span>
                </span>
            @endif
            @if (auth()->check() && auth()->user()->isAdmin())
                <span role="button" tabindex="0" class="entity-privacy-icon" data-toggle="dialog" data-url="{{ route('entities.quick-privacy', [$campaign, $model->entity]) }}" data-target="primary-dialog" aria-haspopup="dialog">
                        <i class="fa-solid fa-lock entity-icons text-2xl" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        <i class="fa-solid fa-lock-open entity-icons text-2xl" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
                    </span>
            @endif
            <div class="dropdown entity-actions flex items-center">
                <div role="button" tabindex="0" data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="entity-submenu" class="cursor-pointer">
                    <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
                    <div class="entity-icons transition-all hover:rotate-45 h-7 w-7 fill-current">
                        @include('icons.svg.cog')
                    </div>

                </div>
                <div class="dropdown-menu hidden" role="menu" id="entity-submenu">
                    @can('update', $model)
                        <x-dropdowns.item :link="route($entity->pluralType() . '.edit', [$campaign, $model->id])" keyboard="edit">
                            <x-icon class="pencil"></x-icon>
                            <span class="grow">{{ __('crud.edit') }}</span>

                            <span class="keyboard-shortcut"  title="{!! __('crud.keyboard-shortcut', ['code' => '[E]']) !!}" data-html="true">E</span>
                        </x-dropdowns.item>
                    @endcan
                    @can('create', $model)
                        <x-dropdowns.item :link="route($entity->pluralType() . '.create', $campaign)">
                            <x-icon class="fa-regular fa-plus"></x-icon>
                            {{ __('crud.actions.new') }}
                        </x-dropdowns.item>
                        @if (method_exists($model, 'getParentKeyName'))
                            <x-dropdowns.item :link="route($entity->pluralType() . '.create', [$campaign, $model->entity, 'parent_id' => $model->id])">
                                <x-icon class="fa-regular fa-plus"></x-icon>
                                {{ __('crud.actions.new_child') }}
                            </x-dropdowns.item>
                        @endif
                        <x-dropdowns.item link="{{ route($entity->pluralType() . '.create', [$campaign, 'copy' => $model->id]) }}">
                            <x-icon class="fa-regular fa-copy"></x-icon>
                            {{ __('crud.actions.copy') }}
                        </x-dropdowns.item>
                    @endcan

                    @if ($model->entity)
                        @if(auth()->check())
                            @can('update', $model)
                                <x-dropdowns.item :link="route('entities.story.reorder', [$campaign, $model->entity->id])">
                                    <x-icon class="fa-solid fa-list-ol"></x-icon>
                                    {{ __('entities/story.reorder.icon_tooltip') }}
                                </x-dropdowns.item>
                            @endcan
                                <x-dropdowns.item link="#" :data="['title' => $model->getEntityType() . ':' . $model->entity->id, 'toggle' => 'tooltip', 'clipboard' => '[' . $model->getEntityType() . ':' . $model->entity->id .']', 'toast' => __('crud.alerts.copy_mention')]">
                                    <x-icon class="fa-solid fa-link"></x-icon>
                                    {{ __('crud.actions.copy_mention') }}
                                </x-dropdowns.item>
                                @can('setTemplates', $campaign)
                                    <x-dropdowns.item :link="route('entities.template', [$campaign, $entity])">
                                        @if($entity->isTemplate())
                                            <x-icon class="fa-regular fa-star"></x-icon>
                                            {{ __('entities/actions.templates.unset') }}
                                        @else
                                            <x-icon class="fa-solid fa-star"></x-icon>
                                            {{ __('entities/actions.templates.set') }}
                                        @endif
                                    </x-dropdowns.item>
                                @endcan
                            <hr class="m-0" />
                                @can('update', $model)
                                    <x-dropdowns.item link="{{ route('entities.relations.create', [$campaign, 'entity' => $model->entity, 'mode' => 'table']) }}" :dialog="route('entities.relations.create', [$campaign, 'entity' => $model->entity, 'mode' => 'table'])">
                                        <x-icon class="fa-solid fa-people-arrows"></x-icon>
                                        {{ __('entities/relations.create.new_title') }}
                                    </x-dropdowns.item>
                                    <hr class="m-0" />
                                @endcan
                        @endif
                        <x-dropdowns.item link="{{ route('entities.html-export', [$campaign, $entity]) }}">
                            <x-icon class="fa-solid fa-print"></x-icon>
                            {{ __('crud.actions.print') }}
                        </x-dropdowns.item>
                        <x-dropdowns.item link="{{ route('entities.json.export', [$campaign, $entity]) }}">
                            <x-icon class="fa-solid fa-download"></x-icon>
                            {{ __('crud.actions.json-export') }}
                        </x-dropdowns.item>
                        <x-dropdowns.item link="{{ route('entities.markdown.export', [$campaign, $entity]) }}">
                            <x-icon class="fa-solid fa-download"></x-icon>
                            {{ __('crud.actions.markdown-export') }}
                        </x-dropdowns.item>
                    @endif
                    @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && auth()->check() && auth()->user()->hasOtherCampaigns($model->campaign_id))
                        <hr class="m-0" />
                        <x-dropdowns.item link="{{ route('entities.move', [$campaign, $entity->id]) }}">
                            <x-icon class="fa-regular fa-clone"></x-icon>
                            @can('update', $model)
                                {{ __('crud.actions.move') }}
                            @else
                                {{ __('crud.actions.copy') }}
                            @endcan
                        </x-dropdowns.item>
                    @endif

                    @if ((empty($disableMove) || !$disableMove) && auth()->check() && auth()->user()->can('move', $model))
                        <x-dropdowns.item link="{{ route('entities.transform', [$campaign, $entity->id]) }}">
                            <x-icon class="fa-solid fa-exchange-alt"></x-icon>
                            {{ __('crud.actions.transform') }}
                        </x-dropdowns.item>
                    @endif

                    @can('delete', $model)
                        @php
                            $url = route('confirm-delete', [$campaign, 'route' => route($entity->pluralType() . '.destroy', [$campaign, $model->id]), 'name' => $entity->name]);
                        @endphp
                        <hr class="m-0" />
                        <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :data="['toggle' => 'dialog', 'target' => 'primary-dialog', 'url' => $url]">
                            <x-icon class="trash"></x-icon>
                            {{ __('crud.remove') }}
                        </x-dropdowns.item>
                    @endcan
                </div>
            </div>
        </div>

        @if ($model instanceof \App\Models\Character && !empty($model->title))
            <div class="entity-title entity-header-line">
                {{ $model->title }}
            </div>
        @endif

        @if (!empty($model->type))
            <div class="entity-type entity-header-line">
                {{ $model->type }}
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
                    {!! $tag->html() !!}
                </a>
            @endforeach
        @endif
        @if(!($model instanceof \App\Models\Tag))
            @can('update', $model)
                <span role="button" tabindex="0" class="entity-privacy-icon text-xl" data-toggle="dialog" data-url="{{ $addTagsUrl }}" data-target="primary-dialog" aria-haspopup="dialog">
                    <x-icon class="fa-solid fa-tag" tooltip="1" :title="__('Add or remove tags')" />
                </span>
            @endcan
        @endif
            </div>
        </div>

        <div class="entity-header-sub flex gap-4 items-center flex-wrap">
        @includeIf('entities.headers._' . $model->getEntityType())
        </div>

        @yield($entityHeaderActions ?? 'entity-header-actions')
    </div>
</div>

@section('modals')
    @parent

    @if (!$campaign->boosted())
        <x-dialog id="booster-cta" :title="__('callouts.booster.titles.boosted')">
            <p class="">{{ __('entities/image.call-to-action') }}</p>
            @if (auth()->check() && auth()->user()->hasBoosters())
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
            <x-icon class="fa-solid fa-spinner fa-spin fa-2x"></x-icon>
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
