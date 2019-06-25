@if ($campaign->enabled('tags') && $model->entity->tags()->count() > 0)
    <li class="list-group-item">
        <b>{{ trans('crud.fields.tags') }}</b>
        <p>
            @foreach ($model->entity->tags as $section)
                <a href="{{ route('tags.show', $section) }}">
                    {!! $section->html() !!}
                </a>
            @endforeach
        </p>
    </li>
@endif