<label class="font-normal text-neutral-content flex gap-2"
@if (!empty($dataProperties)) @foreach ($dataProperties as $key => $val) data-{{ $key }}="{{ $val }}" @endforeach
    @endif>
    <div class="flex gap-2">
        <span>{!! $slot !!}</span>
        <div class="select-none cursor-pointer flex flex-col gap-1">
            <p>{!! $text !!}</p>
            @if (isset($extra)) {!! $extra !!} @endif
        </div>
    </div>
</label>
