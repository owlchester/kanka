@extends('layouts.app', [
    'title' => trans('locations.locations.title', ['name' => $model->name]),
    'description' => trans('locations.locations.description'),
    'breadcrumbs' => [
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.locations')
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('locations._menu', ['active' => 'locations'])
        </div>
        <div class="col-md-9">

            <div class="box box-flat">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('locations.show.tabs.locations') }}
                    </h2>

                    <?php $r = $model->descendants()->with('parent')->acl(auth()->user())->orderBy('name', 'ASC')->paginate(); ?>
                    <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.locations') }}</p>
                    <table id="locations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
                        <tbody><tr>
                            <th class="avatar"><br /></th>
                            <th>{{ trans('locations.fields.name') }}</th>
                            <th>{{ trans('locations.fields.type') }}</th>
                            <th>{{ trans('crud.fields.location') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($r as $model)
                            <tr>
                                <td>
                                    <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route('locations.show', $model->id) }}"></a>
                                </td>
                                <td>
                                    <a href="{{ route('locations.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">{{ $model->name }}</a>
                                </td>
                                <td>
                                    {{ $model->type }}
                                </td>
                                <td>
                                    @if ($model->parent)
                                        <a href="{{ route('locations.show', $model->parent->id) }}" data-toggle="tooltip" title="{{ $model->parent->tooltip() }}">{{ $model->parent->name }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $r->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
