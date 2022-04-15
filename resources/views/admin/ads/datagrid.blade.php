<?php /** @var \App\Models\Ad[] $models */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Section</th>
        <th>Customer</th>
        <th>Is active</th>
        <th>Recent changes</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ route('admin.ads.edit', $model) }}">
                    {!! $model->sectionName() !!}
                </a>
            </td>
            <td>
                {{ $model->customer }}
            </td>
            <td>
                @if ($model->is_active)
                    <i class="fas fa-dollar fa-2x text-success" title="Active" data-toggle="tooltip"></i>
                @endif
            </td>
            <td>
                @if ($model->updater) by {{ $model->updater->name }} @endif {{ $model->updated_at->diffForHumans() }}
            </td>
            <td class="text-right">
                <a href="{{ route('admin.ads.edit', $model) }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-edit"></i> Edit
                </a>

                <a href="/{{ app()->getLocale() }}/campaign/1?_adtest={{ $model->id }}" target="_blank" class="btn btn-sm btn-default">
                    <i class="fa fa-eye"></i> Test
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

