@if ($campaign->enabled('tags') && $model->entity->tags()->acl()->count() > 0)
    <li class="list-group-item">
        <b>{{ trans('crud.fields.tags') }}</b>
        <p>
            @foreach ($model->entity->tags as $section)
                @viewentity($section->entity)
                <a href="{{ route('tags.show', $section) }}">
                    <span class="@if ($section->hasColour()) {{ $section->colourClass() }} @else label label-default @endif">{{ $section->name }}</span>
                </a>
                @endviewentity
            @endforeach
        </p>
    </li>
@endif