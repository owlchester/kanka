
<h3 class="m-0 inline-block mb-5">
    {{ __('campaigns/styles.reorder.title') }}
</h3>
{!! Form::open([
    'route' => ['campaign_styles.reorder-save'],
    'method' => 'POST',
]) !!}
<x-box css="box-entity-story-reorder">
    <div class="element-live-reorder sortable-elements">
        @foreach($reorderStyles as $style)
            <div class="element" data-id="{{ $style->id }}">
                {!! Form::hidden('style[]', $style->id) !!}
                <div class="pr-3">
                    <span class="fa-solid fa-ellipsis-v"></span>
                </div>
                <div class="name overflow-hidden flex-grow">
                    {!! $style->name !!}
                </div>
                <div class="self-end">
                    @if ($style->is_enabled) <i class="fa-solid fa-check-circle"></i>@endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="">
        <button class="btn btn-primary btn-block">
            {{ __('campaigns/styles.reorder.save') }}
        </button>
    </div>
</x-box>

{!! Form::close() !!}
