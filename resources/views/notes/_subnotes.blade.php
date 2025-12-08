<h3 class="text-xl">
    {!! \App\Facades\Module::plural(config('entities.ids.note'), __('entities.notes')) !!}
</h3>
<x-box>
    <div class="grid grid-cols-2 gap-5 md:grid-cols-2 xl:grid-cols-5">
        @foreach ($entity->child->children->sortBy('name') as $subNote)
            <span>
                <x-entity-link
                    :entity="$subNote->entity"
                    :campaign="$campaign" />
                @if($subNote->is_private) <x-icon class="lock" /> @endif
            </span>
        @endforeach
    </div>
</x-box>
