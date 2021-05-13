<?php /**
 * @var \App\Services\CampaignService $campaign
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Tag $tag
 */ ?>
@section('entity-header')
    <div class="row entity-header" @if($campaign->campaign()->boosted() && $model->entity->hasHeaderImage($campaign->campaign()->boosted(true)))style="background-image: url('{{ !empty($model->entity->header_image) ? $model->entity->getImageUrl(0, 0, 'header_image') : ($campaign->campaign()->boosted(true) && !empty($model->entity->header) ? Img::crop(0, 0)->url($model->entity->header->path) : null)}}');"@endif>

        <div class="col-lg-2">
            @if ($model->image)
                <a class="entity-avatar" href="{{ $model->getImageUrl(0) }}" title="{{ $model->name }}" target="_blank">
                    <img src="{{ $model->getImageUrl(0) }}" alt="{{ $model->name }} img">
                </a>
            @elseif ($campaign->campaign()->boosted(true) && $model->entity && $model->entity->image)
                <a class="entity-avatar" href="{{ $model->entity->image->getUrl() }}" title="{{ $model->name }}" target="_blank">
                    <img src="{{ Img::crop(400, 400)->url($model->entity->image->path) }}" alt="{{ $model->name }} img">
                </a>
            @endif
        </div>
        <div class="col-lg-10 entity-header-col">
            <div class="entity-texts">
            <h1 class="entity-name">
                {{ $model->name }}
                @if ($model->is_private)
                    <i class="fas fa-lock entity-icons" title="{{ __('crud.is_private') }}"></i>
                @else
                    <i class="fas fa-lock-open entity-icons" title="{{ __('crud.is_not_private') }}"></i>
                @endif
                @if ($model instanceof \App\Models\Character && $model->is_dead)
                    <span class="ra ra-skull entity-icons" title="{{ __('characters.hints.is_dead') }}"></span>
                @endif

                <div class="btn-group entity-actions">
                    <i class="fas fa-cog entity-icons dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu" role="menu">
                        @can('create', $model)
                            <li>
                                <a href="{{ route($name . '.create') }}">
                                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('crud.actions.new') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route($name . '.create', ['copy' => $model->id]) }}">
                                    <i class="fa fa-copy" aria-hidden="true"></i> {{ __('crud.actions.copy') }}
                                </a>
                            </li>
                        @endcan

                        @if ($model->entity)
                            <li>
                                <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-toggle="tooltip"
                                   data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-success="#copy-mention-success">
                                    <i class="fa fa-link"></i> <span class="hidden-xs">{{ __('crud.actions.copy_mention') }}</span>
                                </a>
                            </li>
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('entities.template', $model->entity) }}">
                                        @if($model->entity->is_template)
                                            <i class="fa fa-star-o" aria-hidden="true"></i> {{ __('entities/actions.templates.unset') }}
                                        @else
                                            <i class="fa fa-star" aria-hidden="true"></i> {{ __('entities/actions.templates.set') }}
                                        @endif
                                    </a>
                                </li>
                            @endif
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('entities.export', $model->entity) }}">
                                    <i class="fa fa-download" aria-hidden="true"></i> {{ __('crud.actions.export') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('entities.json-export', $model->entity) }}">
                                    <i class="fa fa-download" aria-hidden="true"></i> {{ trans('crud.actions.json-export') }}
                                </a>
                            </li>
                        @endif
                        @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && Auth::check() && Auth::user()->hasOtherCampaigns($model->campaign_id))
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('entities.copy_to_campaign', $model->entity->id) }}">
                                    <i class="fa fa-clone" aria-hidden="true"></i> {{ __('crud.actions.copy_to_campaign') }}
                                </a>
                            </li>
                        @endif

                        @if ((empty($disableMove) || !$disableMove) && Auth::user()->can('move', $model))
                            <li>
                                <a href="{{ route('entities.move', $model->entity->id) }}">
                                    <i class="fa fa-exchange-alt" aria-hidden="true"></i> {{ __('crud.actions.move') }}
                                </a>
                            </li>
                        @endif

                        @can('delete', $model)
                            <li class="divider"></li>
                            <li>
                                <a href="#" class="delete-confirm text-red" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                                    <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE','route' => [$name . '.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endcan
                    </ul>
                </div>
            </h1>

            <div class="entity-tags">
                @foreach ($model->entity->tags()->with('entity')->get() as $tag)
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
    </div>
@endsection
