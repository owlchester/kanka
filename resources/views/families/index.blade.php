@extends('layouts.app', [
    'title' => trans('families.index.title'),
    'description' => trans('families.index.description'),
    'breadcrumbs' => [
        ['url' => route('families.index'), 'label' => trans('families.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <a href="{{ route('families.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> {{ trans('families.index.add') }}
                    </a>

                    <div class="box-tools">
                        @include('layouts.datagrid.search', ['route' => route('families.index')])
                    </div>
                </div>

                <div class="box-body no-padding">

                    <table id="families" class="table table-hover">
                        <tbody><tr>
                            <th class="avatar"><br></th>
                            <th><a href="{{ route('families.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('families.fields.name') }}</a></th>
                            <th>{{ trans('families.fields.location') }}</th>
                            <th>{{ trans('families.fields.members') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($models as $family)
                        <tr>
                            <td>
                                <img class="direct-chat-img" src="{{ $family->getImageUrl(true) }}" alt="{{ $family->name }} picture">
                            </td>
                            <td>
                                <a href="{{ route('families.show', $family->id) }}">{{ $family->name }}</a>
                            </td>
                            <td>
                                @if ($family->location)
                                    <a href="{{ route('locations.show', $family->location_id) }}">{{ $family->location->name }}</a>
                                @endif
                            </td>
                            <td>
                                {{ $family->members()->count() }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('families.show', ['id' => $family->id]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody></table>

                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
