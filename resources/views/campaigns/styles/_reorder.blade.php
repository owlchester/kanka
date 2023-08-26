{!! Form::open([
    'route' => ['campaign_styles.reorder-save', $campaign],
    'method' => 'POST',
]) !!}
<div class="flex flex-col gap-5">
    <h3 class="m-0">
        {{ __('campaigns/styles.reorder.title') }}
    </h3>
    <div class="box-entity-story-reorder">
        <div class="element-live-reorder sortable-elements">
            @foreach($reorderStyles as $style)
                <div class="element bg-base-200" data-id="{{ $style->id }}">
                    {!! Form::hidden('style[]', $style->id) !!}
                    <div class="pr-3">
                        <span class="fa-solid fa-ellipsis-v"></span>
                    </div>
                    <div class="name overflow-hidden flex-grow">
                        {!! $style->name !!}
                    </div>
                    <div class="self-end">
                        @if ($style->is_enabled) <x-icon class="fa-solid fa-check-circle" />@endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="">
            <button class="btn2 btn-primary btn-block">
                {{ __('campaigns/styles.reorder.save') }}
            </button>
        </div>
    </div>
</div>
{!! Form::close() !!}
