<table class="table table-striped">
    <thead>
    <tr>
        <th style="width: 40px;">{{ trans('campaigns.fields.image') }}</th>
        <th>{{ trans('campaigns.fields.name') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $campaign)
        <tr>
            <td><a class="entity-image" style="background-image: url('{{ $campaign->getImageUrl(true) }}');" href="{{ app()->getLocale() . '/' . $campaign->getMiddlewareLink() }}"></a></td>
            <td>{{ link_to(app()->getLocale() . '/' . $campaign->getMiddlewareLink(), $campaign->name) }}</td>
            <td>{{ trans('campaigns.visibilities.' . $campaign->visibility) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

