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
    $imageUrl = $model->getImageUrl(0);
    $imagePath = $model->getImageUrl(250, 250);
} elseif ($campaign->campaign()->boosted(true) && !empty($entity) && $entity->image) {
    $imageUrl = $entity->image->getUrl();
    $imagePath = Img::crop(250, 250)->url($entity->image->path);
}
?>
@section('entity-header')
    <div class="row entity-header @if($campaign->campaign()->boosted() && $entity->hasHeaderImage($campaign->campaign()->boosted(true))) with-entity-header" style="background-image: url('{{ !empty($entity->header_image) ? $entity->getImageUrl(0, 0, 'header_image') : ($campaign->campaign()->boosted(true) && !empty($entity->header) ? Img::crop(0, 0)->url($entity->header->path) : null)}}');@endif">

        @if ($imageUrl)
        <div class="col-md-2">
            <a class="entity-image" href="{{ $imageUrl }}" title="{{ $model->name }}" target="_blank" style="background-image: url({{ $imagePath }});">
            </a>
        </div>
        @endif
        <div class="col-md-{{ ($imageUrl) ? 10 : 12 }} entity-header-col">
            <div class="entity-texts">
                <div class="entity-name-header">
                    <h1 class="entity-name">
                        {{ $model->name }}
                    </h1>
                    <div class="entity-name-icons">
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
                                    <li>
                                        <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-toggle="tooltip"
                                           data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-success="#copy-mention-success">
                                            <i class="fa fa-link"></i> {{ __('crud.actions.copy_mention') }}
                                        </a>
                                    </li>
                                    @if (auth()->check() && auth()->user()->isAdmin())
                                        <li>
                                            <a href="{{ route('entities.template', $entity) }}">
                                                @if($entity->is_template)
                                                    <i class="fa fa-star-o" aria-hidden="true"></i> {{ __('entities/actions.templates.unset') }}
                                                @else
                                                    <i class="fa fa-star" aria-hidden="true"></i> {{ __('entities/actions.templates.set') }}
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('entities.export', $entity) }}">
                                            <i class="fa fa-download" aria-hidden="true"></i> {{ __('crud.actions.export') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('entities.json-export', $entity) }}">
                                            <i class="fa fa-download" aria-hidden="true"></i> {{ trans('crud.actions.json-export') }}
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

            <div class="entity-tags">
                @foreach ($entity->tags()->with('entity')->get() as $tag)
                    <a href="{{ route('tags.show', $tag) }}" data-toggle="tooltip-ajax" data-id="{{ $tag->entity->id }}"
                       data-url="{{ route('entities.tooltip', $tag->entity->id) }}">
                        {!! $tag->html() !!}
                    </a>
                @endforeach
            </div>

            @includeIf('entities.headers._' . $model->getEntityType())

            @yield('entity-header-actions')
        </div>
    </div>
@endsection
