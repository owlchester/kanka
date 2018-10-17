@if ($campaign->enabled('tags') && $model->entity->tags()->acl(auth()->user())->count() > 0)
    <li class="list-group-item">
        <b>{{ trans('crud.fields.tags') }}</b>
        <p>
            @foreach ($model->entity->tags as $section)
                <a href="{{ route('tags.show', $section) }}">
                    <span class="label label-default">{{ $section->name }}</span>
                </a>
            @endforeach
        </p>
    </li>
@endif