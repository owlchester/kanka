<div class="grid grid-cols-4 gap-2 md:gap-5">
    @foreach ($elements as $element)
    <div class="rounded bg-base-100 p-2 flex flex-col gap-2 w-[12rem]">
    <div class="flex gap-2">
            <div class="flex-0">
                <input id="{!! $element->type . '_' . $element->id !!}" type="checkbox" name="{!! $element->type !!}[]" value="{{ $element->id }}" />
            </div>
            <div class="grow truncate"> {{ $element->name }} </div>

            <div class="flex-0 text-neutral-content">
                @if ($element->type == 'entity')
                    {{ __('crud.fields.entity') }}
                @else
                    {{ __('entities.post') }}
                @endif
            </div>
        </div>
        <div class="text-neutral-content text-right">
            {{ __('campaigns/recovery.fields.deleted_at', ['date' => \Carbon\Carbon::createFromTimeStamp(strtotime($element->deleted_at))->diffForHumans()])     }}
        </div>
    </div>
    @endforeach
</div>
