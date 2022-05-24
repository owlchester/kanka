<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.default-images') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => trans('campaigns.index.title')],
        __('campaigns.show.tabs.default-images')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'default-images'])
        </div>
        <div class="col-md-9">
            @if ($campaign->boosted())
            <div class="box no-border">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('campaigns.show.tabs.default-images') }}
                    </h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-toggle="dialog"
                                data-target="default-images-help">
                            <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                            {{ __('campaigns.members.actions.help') }}
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">

                    <table class="table table-borderless">
                        <tbody>
                        @foreach ($campaign->defaultImages() as $image)
                            <tr>
                                <td style="width: 60px">
                                    <div class="entity-image pull-left" style="background-image: url({{ Img::crop(40, 40)->url($image['path']) }})"></div>
                                </td>
                                <td>
                                    {{ __('entities.' . $image['type']) }}
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ __('entities.' . $image['type']) }}"
                                            data-target="#delete-confirm" data-delete-target="delete-form-{{ $image['uuid'] }}"
                                            title="{{ __('crud.remove') }}">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => [
                                            'campaign.default-images.delete',
                                        ],
                                        'style' => 'display:inline',
                                        'id' => 'delete-form-' . $image['uuid']
                                    ]) !!}
                                    {!! Form::hidden('entity_type', $image['type']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer no-border">
                    <a href="{{ route('campaign.default-images.create') }}" class="btn btn-primary"
                       data-toggle="ajax-modal" data-target="#entity-modal"
                       data-url="{{ route('campaign.default-images.create') }}">
                        {{ __('campaigns/default-images.actions.add') }}
                    </a>
                </div>
            </div>
            @else
                <h3 class="mt-0">
                    <button class="btn btn-default btn-sm pull-right" data-toggle="dialog"
                            data-target="default-images-help">
                        <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                        {{ __('campaigns.members.actions.help') }}
                    </button>
                    {{ __('campaigns.show.tabs.default-images') }}
                </h3>

                @include('partials.boosted', ['callout' => true])

                <div class="row">
                    <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                        @include('partials.images.boosted-image')
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection


@section('modals')
    @parent

    @include('partials.helper-modal', [
        'id' => 'default-images-help',
        'title' => __('campaigns.show.tabs.default-images'),
        'textes' => [
            __('campaigns/default-images.helper'),
    ]])

@endsection
