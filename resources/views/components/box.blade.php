<div class="rounded p-4 shadow-xs bg-box mb-5" @if(!empty($id)) id="{{ $id }}" @endif>
    {!! $slot !!}
</div>
