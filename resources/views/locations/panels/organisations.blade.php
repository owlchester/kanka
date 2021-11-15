<?php
/** @var \App\Models\Location $model */
$filters = [];
if (request()->has('location_id')) {
    $filters['location_id'] = request()->get('location_id');
}
?>
<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('locations.show.tabs.organisations') }}
        </h3>
    </div>
    <div class="box-body">

        <p class="help-block">

            @if (request()->has('location_id'))
                <a href="{{ route('locations.organisations', $model) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allOrganisations()->count() }})
                </a>
            @else
                <a href="{{ route('locations.organisations', [$model, 'location_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->organisations()->count() }})
                </a>
            @endif
            {{ __('locations.helpers.organisations') }}
        </p>

        <?php  $r = $model->allOrganisations()->filter($filters)->orderBy('name', 'ASC')->with(['members'])->paginate(); ?>

        <table id="items" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('organisations.fields.name') }}</th>
                <th>{{ __('organisations.fields.type') }}</th>
                @if ($campaign->enabled('characters'))<th>{{ __('organisations.fields.members') }}</th>@endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $org)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $org->getImageUrl(40) }}');" title="{{ $org->name }}" href="{{ route('items.show', $org->id) }}"></a>
                    </td>
                    <td>
                        {!! $org->tooltipedLink() !!}
                    </td>
                    <td>{{ $org->type }}</td>

                    @if ($campaign->enabled('characters'))<td>
                        {{ $org->members()->count() }}
                    </td>@endif
                    <td class="text-right">
                        <a href="{{ route('organisations.show', [$org]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ __('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->links() }}
        </div>
    @endif
</div>
