
<h3 class="">
    {{ __('maps/groups.reorder.title') }}
</h3>
{!! Form::open([
    'route' => ['maps.groups.reorder-save', $campaign, 'map' => $model],
    'method' => 'POST',
]) !!}
<div class="box-entity-story-reorder flex flex-col gap-5">
    <div class="element-live-reorder sortable-elements flex flex-col gap-1">
        @foreach($rows as $group)
            <x-reorder.child :id="$group->id">
                {!! Form::hidden('group[]', $group->id) !!}
                <div class="dragger pr-3">
                    <span class="fa-solid fa-ellipsis-v"></span>
                </div>
                <div class="name overflow-hidden flex-grow">
                    {!! $group->name !!}
                    @if ($group->type)
                        <span class="text-neutral-content text-xs">
                            ({{ $group->type }})
                        </span>
                    @endif
                </div>
            </x-reorder.child>
        @endforeach
    </div>
    <button class="btn2 btn-primary btn-block">
        {{ __('maps/groups.reorder.save') }}
    </button>
</div>
{!! Form::close() !!}
