<table class="table table-striped">
    <thead>
    <tr>
        <th class="avatar"></th>
        <th>{{ __('campaigns.fields.name') }}</th>
        <th>{{ __('campaigns.fields.visibility') }}</th>
        <th><i class="fa fa-users"></i></th>
        <th>
            <i class="fas fa-rocket" title="Boosted" data-toggle="tooltip"></i>
        </th>
        <th>
            <i class="fa fa-star" title="Featured" data-toggle="tooltip"></i>
        </th>
        <th>
            <i class="fas fa-door-open" title="Open" data-toggle="tooltip"></i>
        </th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $campaign)
        <tr>
            <td>
                @if ($campaign->image)
                <a class="entity-image" style="background-image: url('{{ $campaign->getImageUrl(40) }}');" href="{{ app()->getLocale() . '/' . $campaign->getMiddlewareLink() }}"></a>
                @endif
            </td>
            <td>{!! $campaign->dashboard() !!}</td>
            <td>{{ $campaign->isPublic() ? 'Public' : 'Private' }}</td>
            <td>
                {{ $campaign->users->count() }}
            </td>
            <td>
                @if ($campaign->boosted())
                    <i class="fas fa-rocket" title="Boosted" data-toggle="tooltip"></i>
                @endif
            </td>
            <td>
                @if ($campaign->is_featured)
                    @if (empty($campaign->featured_until))
                        <i class="fa fa-star" title="Featured" data-toggle="tooltip"></i>
                    @else
                        <i class="fa-solid fa-star-half-stroke" title="Featured until {{ $campaign->featured_until->format('Y.m.d') }}" data-toggle="tooltip"></i>
                    @endif
                @endif
            </td>
            <td>
                @if ($campaign->is_open)
                    <i class="fas fa-door-open" title="Open" data-toggle="tooltip"></i>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.campaigns.show', $campaign) }}">
                    <i class="fas fa-cog"></i> Manage
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

