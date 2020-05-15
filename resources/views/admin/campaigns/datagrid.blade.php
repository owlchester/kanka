<table class="table table-striped">
    <thead>
    <tr>
        <th class="avatar"></th>
        <th>{{ trans('campaigns.fields.name') }}</th>
        <th>{{ trans('campaigns.fields.visibility') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $campaign)
        <tr>
            <td><a class="entity-image" style="background-image: url('{{ $campaign->getImageUrl(40) }}');" href="{{ app()->getLocale() . '/' . $campaign->getMiddlewareLink() }}"></a></td>
            <td>{{ link_to(app()->getLocale() . '/' . $campaign->getMiddlewareLink(), $campaign->name) }}</td>
            <td>{{ trans('campaigns.visibilities.' . $campaign->visibility) }}</td>
            <td>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

