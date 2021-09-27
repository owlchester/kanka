<?php /** @var \App\Models\CampaignStyle $style */?>
@extends('layouts.app', [
    'title' => trans('campaigns/styles.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        __('campaigns.show.tabs.styles')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'styles'])
        </div>
        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-body">
                    <p class="help-block">
                        {!! __('campaigns/styles.helpers.main', ['here' => link_to('https://blog.kanka.io/category/tutorials', __('campaigns/styles.helpers.here'), ['target' => '_blank'])]) !!}
                    </p>

                @if(!$campaign->boosted())
                    @include('partials.boosted', ['callout' => true])
                @else


                    <a href="{{ route('campaign_styles.create') }}" class="btn btn-primary pull-right">
                        <i class="fa fa-plus"></i> {{ __('campaigns/styles.actions.new') }}
                    </a>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('campaigns/styles.fields.name') }}</th>
                            <th>{{ __('campaigns/styles.fields.length') }}</th>
                            <th>{{ __('campaigns/styles.fields.is_enabled') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($styles as $style)
                            <tr>
                                <td>
                                    <a href="{{ route('campaign_styles.edit', $style) }}">{!! $style->name !!}</a>
                                </td>
                                <td>
                                    {{ strlen($style->content) }}
                                </td>
                                <td>
                                    @if($style->is_enabled)
                                        <i class="fa fa-check-circle"></i>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-xs btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right" href="#">
                                            <i class="fa fa-ellipsis-h" data-tree="escape"></i>
                                            <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li>
                                                <a href="{{ route('campaign_styles.edit', [$style]) }}">
                                                    <i class="fa fa-pencil"></i> {{ __('crud.edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="text-danger delete-confirm" data-toggle="modal" data-name="{!! $style->name !!}"
                                                   data-target="#delete-confirm" data-delete-target="delete-form-{{ $style->id }}">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    {{ __('crud.remove') }}
                                                </a>

                                                {!! Form::open(['method' => 'DELETE','route' => ['campaign_styles.destroy', $style], 'style '=> 'display:inline', 'id' => 'delete-form-' . $style->id]) !!}
                                                {!! Form::close() !!}
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {!! $styles->links() !!}
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
