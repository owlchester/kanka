@extends('layouts.app', [
    'title' => trans('campaigns/recovery.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => trans('campaigns.index.title')],
    ],
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'recovery'])
        </div>
        <div class="col-md-9">
            {{ Form::open(['route' => ['recovery']]) }}
            <div class="box no-border">
                <div class="box-body">
                    <p class="help-block">{{ __('campaigns/recovery.helper', ['count' => config('entities.hard_delete')]) }}</p>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 40px">
                                </th>
                                <th class="avatar"></th>
                                <th>{{ __('crud.fields.name') }}</th>
                                <th>{{ __('crud.fields.entity_type') }}</th>
                                <th>{{ __('campaigns/recovery.fields.deleted') }}</th>
                            </tr>
                        </thead>
                        <tbody>
<?php /** @var \App\Models\Entity $entity */?>
@foreach ($entities as $entity)
@php
    $child = $entity->child()->withTrashed()->first();
@endphp
@if (empty($child))
    @continue
@endif
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $entity->id }}">
                            </td>
                            <td>
                                @if ($child)
                                    <div style="background-image: url({{ $child->getImageUrl(40) }});" class="entity-image"></div>
                                @endif
                            </td>
                            <td>
                                {{ $entity->name }}
                            </td>
                            <td>
                                {{ __('entities.' . $entity->type) }}
                            </td>
                            <td>
                                {{ $entity->deleted_at->diffForHumans() }}
                            </td>
                        </tr>
@endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer no-border">
                <div class="row">
                    <div class="col-sm-4">

                        <button class="btn btn-primary">
                            <i class="fa fa-history"></i> {{ __('campaigns/recovery.actions.recover') }}
                        </button>
                    </div>
                    <div class="col-sm-8 text-right">
                        {!! $entities->links() !!}
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>
@endsection

