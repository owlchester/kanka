<label class="font-normal text-neutral-content flex gap-2"
@if (!empty($dataProperties)) @foreach ($dataProperties as $key => $val) data-{{ $key }}="{{ $val }}" @endforeach
    @endif>
    <span>{!! $slot !!}</span>
    <p class="select-none cursor-pointer">{!! $text !!}</p>
</label>
