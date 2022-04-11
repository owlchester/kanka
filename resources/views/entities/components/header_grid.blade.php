<?php /**
 * @var \App\Services\CampaignService $campaign
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 * @var \App\Models\Tag $tag
 */

if (!isset($entity)) {
    $entity = $model->entity;
}

$imageUrl = $imagePath = null;
if ($model->image) {
    $imageUrl = $model->getOriginalImageUrl();
    $imagePath = $model->getImageUrl(250, 250);
} elseif ($campaign->campaign()->boosted(true) && !empty($entity) && $entity->image) {
    $imageUrl = $entity->image->getUrl();
    $imagePath = Img::crop(250, 250)->url($entity->image->path);
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

$superboosted = $campaign->campaign()->boosted();

$hasBanner = false;
if($campaign->campaign()->boosted() && $entity->hasHeaderImage($superboosted)) {
    $hasBanner = true;
}

?>

<div class="entity-header @if ($hasBanner) with-entity-banner @endif">
    @if ($hasBanner)
        <div class="entity-banner" style="background-image: url('{{ $entity->getHeaderUrl($superboosted) }}');">
        </div>
    @endif

    @if ($imageUrl)
    <div class="entity-header-image">

        @can('update', $model)
            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $model->name }}"/>
            @endif

            @if (!isset($printing))
            <a class="entity-image visible-xs" href="{{ $imageUrl }}" target="_blank" style="background-image: url('{{ $imagePath }}');"></a>
            @endif
            <div class="entity-image dropdown-toggle hidden-xs" data-toggle="dropdown" aria-expanded="false" style="background-image: url('{{ $imagePath }}');"></div>


            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li>
                    <a href="{{ $imageUrl }}" target="_blank">
                        <i class="fa fa-external-link"></i> {{ __('entities/image.actions.view') }}
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('entities.image.replace', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.image.replace', $model->entity) }}">
                        {{ __('entities/image.actions.replace_image') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('entities.image.focus', $model->entity) }}">
                        {{ __('entities/image.actions.change_focus') }}
                    </a>
                </li>
            </ul>
        @else

            @if(isset($printing) && $printing)
                <img src="{{ $imagePath }}" class="entity-print-image" alt="{{ $model->name }}"/>
            @else
            <a class="entity-image" href="{{ $imageUrl }}" target="_blank" style="background-image: url('{{ $imagePath }}');"></a>
            @endif
        @endcan
    </div>
    @endif
    <div class="entity-header-text">
        <div class="entity-texts">
            @if (!empty($breadcrumb))
                <ol class="entity-breadcrumb">
                    @foreach ($breadcrumb as $bcdata)
                        <li>
                        @if (is_array($bcdata))
                        <a href="{{ $bcdata['url'] }}" title="{{ $bcdata['label'] }}">
                            {{ $bcdata['label'] }}
                        </a>
                        @elseif(!empty($bcdata))
                            {{ $bcdata }}
                        @endif
                        </li>
                    @endforeach
                </ol>
            @endif
            <div class="entity-name-header">
                <h1 class="entity-name">
                    {{ $model->name }}
                </h1>
                <div class="entity-name-icons entity-name-icons-{{ $buttonsClass }}">
                    @if ($model instanceof \App\Models\Character && $model->is_dead)
                        <i role="button" tabindex="0" class="ra ra-skull entity-icons btn-popover" title="{{ __('characters.hints.is_dead') }}"></i>
                    @endif
                    @if ($model instanceof \App\Models\Quest && $model->is_completed)
                        <i role="button" tabindex="0" class="fas fa-check-circle entity-icons btn-popover" title="{{ __('quests.fields.is_completed') }}"></i>
                    @endif

                    @if (auth()->check() && auth()->user()->isAdmin())
                        @if ($model->is_private)
                            <i role="button" tabindex="0" class="fas fa-lock entity-icons btn-popover" title="{{ __('entities/permissions.quick.title') }}" data-content="{{ __('entities/permissions.quick.private') }}"></i>
                        @else
                            <i role="button" tabindex="0" class="fas fa-lock-open entity-icons btn-popover" title="{{ __('entities/permissions.quick.title') }}" data-content="{{ __('entities/permissions.quick.public') }}"></i>
                        @endif
                    @endif

                    <div class="btn-group entity-actions">
                        <i class="fas fa-cog entity-icons dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            @can('update', $model)
                                <li>
                                    <a href="{{ route($entity->pluralType() . '.edit', $model->id) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ __('crud.edit') }}
                                    </a>
                                </li>
                            @endcan
                            @can('create', $model)
                                <li>
                                    <a href="{{ route($entity->pluralType() . '.create') }}">
                                        <i class="fa fa-plus" aria-hidden="true"></i> {{ __('crud.actions.new') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route($entity->pluralType() . '.create', ['copy' => $model->id]) }}">
                                        <i class="fa fa-copy" aria-hidden="true"></i> {{ __('crud.actions.copy') }}
                                    </a>
                                </li>
                            @endcan

                    @if ($model->entity)
                        @if(auth()->check())
                            @can('update', $model)

                                <li>
                                    <a href="{{ route('entities.story.reorder', $model->entity->id) }}">
                                        <i class="fa fa-list-ol"></i> {{ __('entities/story.reorder.icon_tooltip') }}
                                    </a>
                                </li>
                            @endcan
                                <li>
                                    <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-toggle="tooltip"
                                       data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-toast="{{ __('crud.alerts.copy_mention') }}">
                                        <i class="fa fa-link"></i> {{ __('crud.actions.copy_mention') }}
                                    </a>
                                </li>
                        @if (auth()->user()->isAdmin())
                                    <li>
                                        <a href="{{ route('entities.template', $entity) }}">
                                            @if($entity->is_template)
                                                <i class="fa-regular fa-star" aria-hidden="true"></i> {{ __('entities/actions.templates.unset') }}
                                            @else
                                                <i class="fa-solid fa-star" aria-hidden="true"></i> {{ __('entities/actions.templates.set') }}
                                            @endif
                                        </a>
                                    </li>
                        @endif
                                <li class="divider"></li>
                    @endif
                                <li>
                                    <a href="{{ route('entities.html-export', $entity) }}">
                                        <i class="fa fa-print" aria-hidden="true"></i> {{ __('crud.actions.print') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('entities.json-export', $entity) }}">
                                        <i class="fa fa-download" aria-hidden="true"></i> {{ __('crud.actions.json-export') }}
                                    </a>
                                </li>
                            @endif
                            @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && auth()->check() && auth()->user()->hasOtherCampaigns($model->campaign_id))
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('entities.move', $entity->id) }}">
                                        <i class="fa fa-clone" aria-hidden="true"></i> {{ __('crud.actions.move') }}
                                    </a>
                                </li>
                            @endif

                            @if ((empty($disableMove) || !$disableMove) && auth()->check() && auth()->user()->can('move', $model))
                                <li>
                                    <a href="{{ route('entities.transform', $entity->id) }}">
                                        <i class="fa fa-exchange-alt" aria-hidden="true"></i> {{ __('crud.actions.transform') }}
                                    </a>
                                </li>
                            @endif

                            @can('delete', $model)
                                <li class="divider"></li>
                                <li>
                                    <a href="#" class="delete-confirm text-red" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                                        <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => [$entity->pluralType() . '.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                                    {!! Form::close() !!}
                                </li>
                            @endcan
                        </ul>
                    </div>
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
        <div class="entity-tags entity-header-line">
            @foreach ($entityTags as $tag)
                <a href="{{ route('tags.show', $tag) }}" data-toggle="tooltip-ajax"
                   data-id="{{ $tag->entity->id }}" data-url="{{ route('entities.tooltip', $tag->entity->id) }}"
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

