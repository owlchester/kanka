<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 * @var \App\Models\Tag $tag
 */

if (!isset($entity)) {
    $entity = $model->entity;
}

$imageUrl = $imagePath = $headerImageUrl = $imagePathXL = $imagePathMobile = null;
if ($model->image) {
    $imageUrl = $model->getOriginalImageUrl();
    $imagePath = $model->thumbnail(170);
    $imagePathXL = $model->thumbnail(400);
    $imagePathMobile = $model->thumbnail(100);
} elseif ($campaign->superboosted() && !empty($entity) && $entity->image) {
    $imageUrl = $entity->image->getUrl();
    $imagePath = $entity->image->getUrl(170, 170);
    $imagePathXL = $entity->image->getUrl(400, 400);
    $imagePathMobile = $entity->image->getUrl(100, 100);
}
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

$superboosted = $campaign->superboosted();

$hasBanner = false;
if($campaign->boosted() && $entity->hasHeaderImage($superboosted)) {
    $hasBanner = true;
    $headerImageUrl = $entity->getHeaderUrl($superboosted);
}

?>

<div class="entity-header pb-5 flex flex-wrap @if ($hasBanner) with-entity-banner m-0 @endif">
    @if ($hasBanner)
        <div class="entity-banner cover-image" style="background-image: url('{{ $headerImageUrl }}');">
        </div>
    @endif

    @if ($imageUrl)
    <div class="entity-header-image relative">

        @can('update', $model)
            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $model->name }}"/>
            @endif

            @if (!isset($printing))
            <a class="entity-image cover-background visible-xs" href="{{ $imageUrl }}" target="_blank" style="background-image: url('{{ $imagePathMobile }}');"></a>
            @endif
            <div class="cursor-pointer dropdown-toggle hidden-xs print-none" data-toggle="dropdown" aria-expanded="false">
                <picture>
                    <source media="(min-width:766px)" srcset="{{ $imagePathXL }}">
                    <img src="{{ $imagePath }}" alt="{{ $model->name }}" style="width:auto;">
                </picture>
            </div>

            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li>
                    <a href="{{ $imageUrl }}" target="_blank">
                        <x-icon class="fa-solid fa-external-link"></x-icon>
                        {{ __('entities/image.actions.view') }}
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('entities.image.replace', [$campaign, $model->entity]) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.image.replace', [$campaign, $model->entity]) }}">
                        {{ __('entities/image.actions.replace_image') }}
                    </a>
                </li>
                <li>
                    @if ($campaign->boosted())
                    <a href="{{ route('entities.image.focus', [$campaign, $model->entity]) }}">
                        {{ __('entities/image.actions.change_focus') }}
                    </a>
                    @else
                    <a href="#" data-toggle="dialog" data-target="booster-cta">
                        {{ __('entities/image.actions.change_focus') }}
                    </a>
                    @endif
                </li>
            </ul>
        @else

            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $model->name }}"/>
            @else
            <a class="entity-image cover-background" href="{{ $imageUrl }}" target="_blank" style="background-image: url('{{ $imagePath }}');"></a>
            @endif
        @endcan
    </div>
    @endif
    <div class="entity-header-text flex flex-col">
        <div class="entity-texts">
            @if (!empty($breadcrumb))
                <ol class="entity-breadcrumb text-xs mb-2 p-0">
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
                <h1 class="entity-name text-4xl m-0 break-all">
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

                @if (auth()->check() && auth()->user()->isAdmin())
                    <span role="button" tabindex="0" class="entity-privacy-icon" data-toggle="dialog-ajax" data-url="{{ route('entities.quick-privacy', [$campaign, $model->entity]) }}" data-target="quick-privacy" aria-haspopup="dialog">
                            <i class="fa-solid fa-lock entity-icons text-2xl" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                            <i class="fa-solid fa-lock-open entity-icons text-2xl" data-title="{{ __('entities/permissions.quick.title') }}" data-toggle="tooltip" aria-hidden="true"></i>
                            <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
                        </span>
                @endif
                <div class="dropdown entity-actions">
                    <span role="button" tabindex="0" data-toggle="dropdown" aria-expanded="false" aria-haspopup="menu" aria-controls="entity-submenu">
                        <i class="fa-solid fa-cog entity-icons cursor-pointer text-2xl transition-all hover:rotate-45" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
                    </span>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu" id="entity-submenu">
                        @can('update', $model)
                            <li>
                                <a href="{{ route($entity->pluralType() . '.edit', [$campaign, $model->id]) }}" data-keyboard="edit">
                                    <x-icon class="pencil"></x-icon>
                                    <span class="grow">{{ __('crud.edit') }}</span>

                                    <span class="keyboard-shortcut"  title="{!! __('crud.keyboard-shortcut', ['code' => '[E]']) !!}" data-html="true">E</span>
                                </a>
                            </li>
                        @endcan
                        @can('create', $model)
                            <li>
                                <a href="{{ route($entity->pluralType() . '.create', $campaign) }}">
                                    <x-icon class="fa-regular fa-plus"></x-icon>
                                    {{ __('crud.actions.new') }}
                                </a>
                            </li>
                            @if (\Illuminate\Support\Facades\Route::has($entity->pluralType() . '.tree'))
                                <li>
                                    <a href="{{ route($entity->pluralType() . '.create', [$campaign, $model->entity, 'parent_id' => $model->id]) }}">
                                        <x-icon class="fa-regular fa-plus"></x-icon>
                                        {{ __('crud.actions.new_child') }}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route($entity->pluralType() . '.create', [$campaign, $model->entity, 'copy' => $model->id]) }}">
                                    <x-icon class="fa-regular fa-copy"></x-icon>
                                    {{ __('crud.actions.copy') }}
                                </a>
                            </li>
                        @endcan

                        @if ($model->entity)
                            @if(auth()->check())
                                @can('update', $model)
                                    <li>
                                        <a href="{{ route('entities.story.reorder', [$campaign, $model->entity->id]) }}">
                                            <x-icon class="fa-solid fa-list-ol"></x-icon>
                                            {{ __('entities/story.reorder.icon_tooltip') }}
                                        </a>
                                    </li>
                                @endcan
                                <li>
                                    <a href="#" data-title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-toggle="tooltip"
                                       data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-toast="{{ __('crud.alerts.copy_mention') }}">
                                        <x-icon class="fa-solid fa-link"></x-icon>
                                        {{ __('crud.actions.copy_mention') }}
                                    </a>
                                </li>
                                @if (auth()->user()->isAdmin())
                                    <li>
                                        <a href="{{ route('entities.template', [$campaign, $entity]) }}">
                                            @if($entity->is_template)
                                                <x-icon class="fa-regular fa-star"></x-icon>
                                                {{ __('entities/actions.templates.unset') }}
                                            @else
                                                <x-icon class="fa-solid fa-star"></x-icon>
                                                {{ __('entities/actions.templates.set') }}
                                            @endif
                                        </a>
                                    </li>
                                @endif
                                <li class="divider"></li>
                                    @can('update', $model)
                                        <li>
                                            <a href="{{ route('entities.relations.create', [$campaign, 'entity' => $model->entity, 'mode' => 'table']) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$campaign, 'entity' => $model->entity, 'mode' => 'table']) }}">
                                                <x-icon class="fa-solid fa-people-arrows"></x-icon>
                                                {{ __('entities/relations.create.new_title') }}
                                            </a>
                                        </li>
                                    @endcan
                                <li class="divider"></li>
                            @endif
                            <li>
                                <a href="{{ route('entities.html-export', [$campaign, $entity]) }}">
                                    <x-icon class="fa-solid fa-print"></x-icon>
                                    {{ __('crud.actions.print') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('entities.json-export', [$campaign, $entity]) }}">
                                    <x-icon class="fa-solid fa-download"></x-icon>
                                    {{ __('crud.actions.json-export') }}
                                </a>
                            </li>
                        @endif
                        @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && auth()->check() && auth()->user()->hasOtherCampaigns($model->campaign_id))
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('entities.move', [$campaign, $entity->id]) }}">
                                    <x-icon class="fa-regular fa-clone"></x-icon>
                                    {{ __('crud.actions.move') }}
                                </a>
                            </li>
                        @endif

                        @if ((empty($disableMove) || !$disableMove) && auth()->check() && auth()->user()->can('move', $model))
                            <li>
                                <a href="{{ route('entities.transform', [$campaign, $entity->id]) }}">
                                    <x-icon class="fa-solid fa-exchange-alt"></x-icon>
                                    {{ __('crud.actions.transform') }}
                                </a>
                            </li>
                        @endif

                        @can('delete', $model)
                            <li class="divider"></li>
                            <li>
                                <a href="#" class="delete-confirm text-red" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm" data-recoverable="1">
                                    <x-icon class="trash"></x-icon>
                                    {{ __('crud.remove') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => [$entity->pluralType() . '.destroy', [$campaign, $model->id]], 'style' => 'display:inline', 'id' => 'delete-confirm-form']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>

        <div>
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

        @if($entityTags->count() > 0)
        <div class="entity-tags entity-header-line text-xs flex  flex-wrap gap-2 mb-1 mt-2">
            @foreach ($entityTags as $tag)
                @if (!$tag->entity) @continue @endif
                <a href="{{ route('tags.show', [$campaign, $tag]) }}" data-toggle="tooltip-ajax"
                   data-id="{{ $tag->entity->id }}" data-url="{{ route('entities.tooltip', [$campaign, $tag->entity->id]) }}"
                   data-tag-slug="{{ $tag->slug }}"
                >
                    {!! $tag->html() !!}
                </a>
            @endforeach
        </div>
        @endif

        @includeIf('entities.headers._' . $model->getEntityType())

        @yield($entityHeaderActions ?? 'entity-header-actions')
        </div>
    </div>
</div>

@section('modals')
    @parent


    @if (!$campaign->boosted())
        <x-dialog id="booster-cta" :title="__('callouts.booster.titles.boosted')">
            <p class="mb-2">{{ __('entities/image.call-to-action') }}</p>
            @subscriber()
            <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn bg-boost text-white btn-block mb-2">
                {!! __('callouts.premium.unlock', ['campaign' => $campaign->name]) !!}
            </a>
            @else
                <p class="mb-2">{{ __('callouts.booster.limitation') }}</p>
                <a href="{{ \App\Facades\Domain::toFront('premium')  }}" class="btn bg-boost text-white btn-block mb-2">
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
