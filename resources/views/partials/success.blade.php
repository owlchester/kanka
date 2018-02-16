@if (session('success') or session('success_raw'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @if (session('success_raw'))
            {!! session('success_raw') !!}
        @else
            {{ session('success') }}
        @endif
    </div>
@endif