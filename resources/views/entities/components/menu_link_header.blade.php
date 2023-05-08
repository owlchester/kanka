<?php /**
 * @var \App\Services\CampaignService $campaign
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 * @var \App\Models\Tag $tag
 */


?>
    <div class="entity-header pb-5 flex flex-wrap">
        <div class="entity-header-text flex flex-col">
            <div class="entity-texts">
                @if (!empty($breadcrumb))
                    <ol class="entity-breadcrumb text-xs mb-2 p-0">
                        @foreach ($breadcrumb as $bcdata)
                            <li class="inline-block">
                                @if (is_array($bcdata))
                                    <a href="{{ $bcdata['url'] }}" class="no-underline" title="{{ $bcdata['label'] }}">
                                        {{ $bcdata['label'] }}
                                    </a>
                                @elseif(!empty($bcdata))
                                    {{ $bcdata }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif

                <div class="entity-name-header flex items-center">
                    <h1 class="entity-name">
                        {{ $model->name }}
                    </h1>
                    <div class="entity-name-icons">
                        @if (auth()->check() && auth()->user()->isAdmin())
                            @if ($model->is_private)
                                <i role="button" tabindex="0" class="fa-solid fa-lock entity-icons cursor-pointer text-xl btn-popover" title="{{ __('entities/permissions.quick.title') }}" data-content="{{ __('entities/permissions.quick.private') }}"></i>
                            @else
                                <i role="button" tabindex="0" class="fa-solid fa-lock-open entity-icons cursor-pointer text-xl btn-popover" title="{{ __('entities/permissions.quick.title') }}" data-content="{{ __('entities/permissions.quick.public') }}"></i>
                            @endif
                        @endif

                        <div class="btn-group entity-actions">
                            <i class="fa-solid fa-cog entity-icons cursor-pointer text-xl dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">

                                @can('delete', $model)
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#" class="delete-confirm text-red" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                                            <x-icon class="fa-solid fa-trash"></x-icon>
                                            {{ __('crud.remove') }}
                                        </a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['menu_links.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                                        {!! Form::close() !!}
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            @includeIf('entities.headers._' . $model->getEntityType())

            <div class="header-buttons inline-block pull-right ml-auto">

                @can('update', $model)
                    <a href="{{ route('menu_links.edit', $model) }}" class="btn btn-primary">
                        <x-icon class="pencil"></x-icon>
                        {{ __('crud.update') }}
                    </a>
                @endcan
            </div>
        </div>
    </div>
