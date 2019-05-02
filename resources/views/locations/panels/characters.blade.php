<?php
$filters = [];
if (request()->has('location_id')) {
    $filters['location_id'] = request()->get('location_id');
}
?>
<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.characters') }}
        </h2>


        <p class="help-block export-hidden">
            @if (request()->has('location_id'))
                <a href="{{ route('locations.characters', $model) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allCharacters()->acl()->count() }})
                </a>
            @else
                <a href="{{ route('locations.characters', [$model, 'location_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->characters()->acl()->count() }})
                </a>
            @endif
            {{ trans('locations.helpers.characters') }}
        </p>

        <?php  $r = $model->allCharacters()->acl()->filter($filters)->orderBy('name', 'ASC')->with(['location', 'family'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.characters') }}</p>
        <table id="characters" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('characters.fields.name') }}</th>
                @if ($campaign->enabled('families'))
                    <th>{{ trans('characters.fields.family') }}</th>
                @endif
                <th>{{ trans('crud.fields.location') }}</th>
                <th>{{ trans('characters.fields.age') }}</th>
                @if ($campaign->enabled('races'))
                    <th>{{ trans('characters.fields.race') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $character)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $character->getImageUrl(true) }}');" title="{{ $character->name }}" href="{{ route('characters.show', $character->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('characters.show', $character->id) }}" data-toggle="tooltip" title="{{ $character->tooltip() }}">{{ $character->name }}</a>
                    </td>
                    @if ($campaign->enabled('families'))
                        <td>
                            @if ($character->family)
                                <a href="{{ route('families.show', $character->family_id) }}" data-toggle="tooltip" title="{{ $character->family->tooltip() }}">{{ $character->family->name }}</a>
                            @endif
                        </td>
                    @endif
                    <td>
                        <a href="{{ route('locations.show', $character->location_id) }}" data-toggle="tooltip" title="{{ $character->location->tooltip() }}">{{ $character->location->name }}</a>
                    </td>
                    <td>{{ $character->age }}</td>
                    @if ($campaign->enabled('races'))
                        <td>
                            @if ($character->race)
                                <a href="{{ route('races.show', $character->race_id) }}" data-toggle="tooltip" title="{{ $character->race->tooltip() }}">{{ $character->race->name }}</a>
                            @endif
                        </td>
                    @endif
                    <td class="text-right">
                        <a href="{{ route('characters.show', ['id' => $character->id]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->appends($filters)->links() }}
    </div>
</div>