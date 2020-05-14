<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => trans('campaigns/default-images.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => trans('campaigns.index.title')],
    ],
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'default-images'])
        </div>
        <div class="col-md-9">
            <div class="box no-border">
                <div class="box-body">
                    <p class="help-block">{{ __('campaigns/default-images.helper') }}</p>

                    <table class="table table-borderless">
                        <tbody>
                        @foreach ($campaign->defaultImages() as $image)
                            <tr>
                                <td style="width: 60px">
                                    <div class="entity-image float-left" style="background-image: url({{ Img::crop(40, 40)->url($image['path']) }})"></div>
                                </td>
                                <td>
                                    {{ __('entities.' . $image['type']) }}
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ __('entities.' . $image['type']) }}"
                                            data-target="#delete-confirm" data-delete-target="delete-form-{{ $image['uuid'] }}"
                                            title="{{ __('crud.remove') }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => [
                                            'campaign.default-images',
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
        </div>
    </div>
@endsection

