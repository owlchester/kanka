@if (session('success') or session('success_raw'))
    <x-alert type="success" class="alert-header" :dismissible="true">
        @if (session('success_raw'))
            {!! session('success_raw') !!}
        @else
            {{ session('success') }}
        @endif
    </x-alert>
@endif
@if (session('warning'))
    <x-alert type="warning" class="alert-header" :dismissible="true">
        {{ session('warning') }}
    </x-alert>
@endif
@if (session('error') or session('error_raw'))
    <x-alert type="danger" class="alert-header" :dismissible="true">
        @if (session('error_raw'))
            {!! session('error_raw') !!}
        @else
            {{ session('error') }}
        @endif
    </x-alert>
@endif
