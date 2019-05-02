<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('families.show.tabs.members') }}
        </h2>

        <p class="help-block">{{ trans('families.members.helpers.direct_members') }}</p>

        <table id="family-characters" class="table table-hover">
            <thead><tr>
                <th class="avatar"><br></th>
                <th>{{ trans('characters.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                <th>{{ trans('characters.fields.location') }}</th>
                @endif
                <th>{{ trans('characters.fields.age') }}</th>
                @if ($campaign->enabled('races'))
                <th>{{ trans('characters.fields.race') }}</th>
                @endif
                <th>{{ trans('characters.fields.sex') }}</th>
                <th>{{ trans('characters.fields.is_dead') }}</th>
            </tr></thead>
            <tbody>
            <?php $r = $model->members()->acl()->paginate();?>
            @foreach ($r->sortBy('character.name') as $member)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $member->getImageUrl(true) }}');" title="{{ $member->name }}" href="{{ route('characters.show', $member->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('characters.show', $member->id) }}" data-toggle="tooltip" title="{{ $member->tooltipWithName() }}" data-html="true">{{ $member->name }}</a>
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td>
                        @if ($member->location)
                            <a href="{{ route('locations.show', $member->location_id) }}" data-toggle="tooltip" title="{{ $member->location->tooltip() }}">{{ $member->location->name }}</a>
                        @endif
                    </td>
                    @endif
                    <td>{{ $member->age }}</td>
                    @if ($campaign->enabled('races'))
                        <td>
                            @if ($member->race)
                                <a href="{{ route('races.show', $member->race_id) }}" data-toggle="tooltip" title="{{ $member->race->tooltip() }}">{{ $member->race->name }}</a>
                            @endif
                        </td>
                    @endif
                    <td>{{ $member->sex }}</td>
                    <td>@if ($member->is_dead)<span class="ra ra-skull"></span>@endif</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>