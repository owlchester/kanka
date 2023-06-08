
<h3 class="">
    {{ __('maps/groups.reorder.title') }}
</h3>
{!! Form::open([
    'route' => ['maps.groups.reorder-save', 'map' => $model],
    'method' => 'POST',
]) !!}
    <div class="box-entity-story-reorder">

        <div class="element-live-reorder sortable-elements">
            @foreach($rows as $group)
                <div class="element" data-id="{{ $group->id }}">
                    {!! Form::hidden('group[]', $group->id) !!}
                    <div class="dragger pr-3">
                        <span class="fa-solid fa-ellipsis-v"></span>
                    </div>
                    <div class="name overflow-hidden flex-grow">
                        {!! $group->name !!}
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn2 btn-primary btn-block">
            {{ __('maps/groups.reorder.save') }}
        </button>
    </div>
{!! Form::close() !!}
