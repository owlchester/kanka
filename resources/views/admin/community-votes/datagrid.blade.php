<?php /** @var \App\Models\CommunityVote $model */ ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('community-vote.fields.name') }}</th>
        <th>{{ __('community-vote.fields.status') }}</th>
        <th>{{ __('community-vote.fields.votes') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td>
                <a href="{{ route('community-votes.show', $model) }}">{{ $model->name }}</a>
            </td>
            <td>{{ $model->status() }}</td>
            <td>{{ $model->ballots->count() }}</td>
            <td>
                <a href="{{ route('admin.community-votes.edit', $model) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

