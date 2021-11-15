<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityLink $link */?>
@extends('layouts.app', [
    'title' => __('entities/links.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.links')
    ],
    'mainTitle' => false,
    'miscModel' => $entity->child,
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include($entity->pluralType() . '._menu', ['active' => 'links', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">
                        {{ __('crud.tabs.links') }}
                    </h3>
                </div>
                <div class="box-body">

                    <p class="help-block">
                        {{ __('entities/links.show.helper') }}
                    </p>

                    @can('update', $entity->child)
                        <div class="pull-right">
                            <a href="{{ route('entities.entity_links.create', $entity) }}" class="btn btn-sm btn-primary"
                               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_links.create', $entity) }}">
                                <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('entities/links.actions.add') }}</span>
                                <span class="visible-xs visible-sm">{{ __('crud.add') }}</span>
                            </a>
                        </div>
                    @endcan

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('entities/links.fields.name') }}</th>
                            <th>{{ __('entities/links.fields.url') }}</th>
                            <th>{{ __('entities/links.fields.icon') }}</th>
                            @if (Auth::check())
                                <th>{{ __('crud.fields.visibility') }}</th>
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($entity->links()->ordered()->get() as $link)
                            <tr>
                                <td>
                                    {{ $link->name }}
                                </td>
                                <td>
                                    {!! link_to($link->url, $link->url, ['target' => '_blank', 'rel' => "noreferrer nofollow"]) !!}
                                </td>
                                <td>
                                    <i class="{{ $link->iconName() }}"></i>
                                </td>
                                @if (Auth::check())
                                    <td>
                                        @include('cruds.partials.visibility', ['model' => $link])
                                    </td>
                                    @can('update', $entity->child)
                                        <td class="text-right">
                                            <a href="{{ route('entities.entity_links.edit', ['entity' => $entity, 'entity_link' => $link->id]) }}"
                                               data-toggle="ajax-modal" data-target="#entity-modal"
                                               data-url="{{ route('entities.entity_links.edit', ['entity' => $entity, 'entity_link' => $link->id]) }}"
                                               title="{{ __('crud.edit') }}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $link->name }}"
                                                    data-target="#delete-confirm" data-delete-target="delete-form-link-{{ $link->id }}" title="{{ __('crud.remove') }}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_links.destroy', 'entity' => $entity, 'entity_link' => $link], 'style' => 'display:inline', 'id' => 'delete-form-link-' . $link->id]) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    @endcan
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
