<div class="rounded @if($padding) p-4 @endif shadow-xs bg-box mb-5 {{ $css }}" @if(!empty($id)) id="{{ $id }}" @endif>
    {!! $slot !!}
</div>
