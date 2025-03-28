<form
    method="{{ $method == 'GET' ? 'GET' : 'POST' }}"
    action="{{ $action() }}"
    role="form"
@if (in_array($method, ['POST', 'PATCH']) && !$direct)    data-maintenance="1" @endif
@if ($files) enctype="multipart/form-data" @endif
@if ($unsaved) data-unload="1" @endif
@if ($shortcut && $method !== 'DELETE') data-shortcut="1" @endif
    class="w-full {{ $class }}"
@if (!empty($id)) id="{{ $id }}" @endif

{!! $extra() !!}
>
    @if ($method !== 'GET')
        @csrf
    @endif
    @if (!in_array($method, ['GET', 'POST']))
        <input type="hidden" name="_method" value="{{ $method }}">
    @endif
    {!! $slot !!}
</form>
