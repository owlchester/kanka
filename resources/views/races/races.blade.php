@extends('layouts.app', [
    'title' => trans('races.races.title', ['name' => $model->name]),
    'description' => trans('races.races.description'),
    'breadcrumbs' => [
        ['url' => route('races.show', $model), 'label' => $model->name],
        trans('races.show.tabs.races')
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('races._menu', ['active' => 'races'])
        </div>
        <div class="col-md-9">

            <div class="box box-flat">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('races.show.tabs.races') }}
                    </h2>

                    <?php  $r = $model->races()->acl(auth()->user())->orderBy('name', 'ASC')->with(['characters'])->paginate(); ?>
                    <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('races.show.tabs.races') }}</p>
                    <table id="races" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
                        <tbody><tr>
                            <th class="avatar"><br /></th>
                            <th>{{ trans('races.fields.name') }}</th>
                            @if ($campaign->enabled('characters'))
                                <th>{{ trans('races.fields.characters') }}</th>
                            @endif
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($r as $race)
                            <tr>
                                <td>
                                    <a class="entity-image" style="background-image: url('{{ $race->getImageUrl(true) }}');" title="{{ $race->name }}" href="{{ route('races.show', $race->id) }}"></a>
                                </td>
                                <td>
                                    <a href="{{ route('races.show', $race->id) }}" data-toggle="tooltip" title="{{ $race->tooltip() }}">{{ $race->name }}</a>
                                </td>
                                @if ($campaign->enabled('characters'))
                                <td>
                                    {{ $race->characters()->count() }}
                                </td>
                                @endif
                                <td class="text-right">
                                    <a href="{{ route('races.show', ['id' => $race->id]) }}" class="btn btn-xs btn-primary">
                                        <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                                    </a>
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
