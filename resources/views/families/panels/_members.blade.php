<?php
/**
 * @var \App\Models\Family $model
 * @var \App\Models\Character $member
 */
$filters = [];
$allMembers = true;
if (!request()->has('all_members')) {
    $filters['family_id'] = $model->id;
    $allMembers = false;
}

if (!$allMembers) {
    $r = $model->members();
} else {
    $r = $model->allMembers();
}
$datagridSorter = new \App\Datagrids\Sorters\FamilyCharacterSorter();
$datagridSorter->request(request()->all());
$r = $r->with(['entity', 'races', 'races.entity', 'location', 'location.entity', 'families', 'families.entity'])->simpleSort($datagridSorter)->orderBy('name')->paginate();
?>
<div class="box box-solid" id="family-members">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('families.show.tabs.members') }}
        </h3>
        <div class="box-tools pull-right">
            @if (!$allMembers)
                <a href="{{ route('families.show', [$model, 'all_members' => true, '#family-members']) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allMembers()->count() }})
                </a>
            @else
                <a href="{{ route('families.show', [$model, '#family-members']) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->members()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div class="box-body">
        <p class="help-block">{{ __('families.members.helpers.direct_members') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#family-members'])

        <table id="family-characters" class="table table-hover margin-top">
            <thead><tr>
                <th class="avatar"><br></th>
                <th>{{ __('characters.fields.name') }}</th>
                @if($allMembers)<th>{{ __('characters.fields.families') }}</th>@endif
                @if ($campaign->enabled('locations'))
                    <th class="hidden-xs hidden-sm">{{ __('characters.fields.location') }}</th>
                @endif
                @if ($campaign->enabled('races'))
                    <th class="hidden-xs hidden-sm">{{ __('characters.fields.races') }}</th>
                @endif
                <th>{{ __('characters.fields.sex') }}</th>
            </tr></thead>
            <tbody>
            @foreach ($r as $member)
                <tr class="{{ $member->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $member->getImageUrl(40) }}');" title="{{ $member->name }}" href="{{ route('characters.show', $member->id) }}"></a>
                    </td>
                    <td>
                        @if ($member->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $member->tooltipedLink() !!} @if ($member->is_dead)<span class="ra ra-skull" data-toggle="tooltip" title="{{ __('characters.hints.is_dead') }}"></span>@endif<br />
                        <i>{{ $member->title }}</i>
                    </td>
                    @if($allMembers)<td>
                        @foreach ($member->families as $family)
                            {!! $family->tooltipedLink() !!}
                        @endforeach
                    </td>@endif
                    @if ($campaign->enabled('locations'))
                        <td class="hidden-xs hidden-sm">
                            @if ($member->location)
                                {!! $member->location->tooltipedLink() !!}
                            @endif
                        </td>
                    @endif
                    @if ($campaign->enabled('races'))
                        <td class="hidden-xs hidden-sm">
                            @foreach ($member->races as $race)
                                {!! $race->tooltipedLink() !!}
                            @endforeach
                        </td>
                    @endif
                    <td>{{ $member->sex }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->appends('all_members', request()->get('all_members'))->fragment('family-members')->links() }}
    </div>
</div>
