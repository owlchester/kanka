<h3 class="">
    {!! \App\Facades\Module::plural(config('entities.ids.note'), __('entities.notes')) !!}
</h3>
<x-box>
    <div class="grid grid-cols-2 gap-5 md:grid-cols-2 xl:grid-cols-5">
        @foreach ($model->notes->sortBy('name') as $subNote)
            <span>{!! $subNote->tooltipedLink() !!} @if($subNote->is_private) <i class="fa-solid fa-lock"></i> @endif</span>
        @endforeach
    </div>
</x-box>
