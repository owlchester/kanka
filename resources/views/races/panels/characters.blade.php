<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('races.show.tabs.characters') }}
        </h2>

        <?php  $r = $model->characters()->acl()->orderBy('name', 'ASC')->with(['family'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('races.show.tabs.characters') }}</p>
        <table id="characters" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('characters.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                    <th>{{ trans('crud.fields.location') }}</th>
                @endif
                @if ($campaign->enabled('families'))
                    <th>{{ trans('characters.fields.family') }}</th>
                @endif
                <th>{{ trans('characters.fields.age') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $character)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $character->getImageUrl(true) }}');" title="{{ $character->name }}" href="{{ route('characters.show', $character->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('characters.show', $character->id) }}" data-toggle="tooltip" title="{{ $character->tooltipWithName() }}" data-html="true">{{ $character->name }}</a>
                    </td>
                    @if ($campaign->enabled('locations'))
                        <td>
                            @if ($character->location)
                                <a href="{{ route('locations.show', $character->location_id) }}" data-toggle="tooltip" title="{{ $character->location->tooltipWithName() }}" data-html="true">{{ $character->location->name }}</a>
                            @endif
                        </td>
                    @endif
                    @if ($campaign->enabled('families'))
                    <td>
                        @if ($character->family)
                            <a href="{{ route('families.show', $character->family_id) }}" data-toggle="tooltip" title="{{ $character->family->tooltipWithName() }}" data-html="true">{{ $character->family->name }}</a>
                        @endif
                    </td>
                    @endif
                    <td>{{ $character->age }}</td>
                    <td class="text-right">
                        <a href="{{ route('characters.show', ['id' => $character->id]) }}" class="btn btn-xs btn-primary">
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