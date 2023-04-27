@if (session('success') or session('success_raw'))
    <div class="alert alert-success alert-dismissable border-0 shadow-xs mb-5 flex items-center p-4">
        <div class="grow">
            @if (session('success_raw'))
                {!! session('success_raw') !!}
            @else
                {{ session('success') }}
            @endif
        </div>
        <div class="flex-none">
            <button type="button" data-dismiss="alert" aria-hidden="true">
                <i class="fa-solid fa-times" aria-hidden="true"></i>
                <span class="sr-only">{{ __('crud.click_modal.close') }}</span>
            </button>
        </div>
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning alert-dismissable border-0 shadow-xs mb-5 flex items-center p-4">
        <div class="grow">
            {{ session('warning') }}
        </div>
        <div class="flex-none">
            <button type="button" data-dismiss="alert" aria-hidden="true">
                <i class="fa-solid fa-times" aria-hidden="true"></i>
                <span class="sr-only">{{ __('crud.click_modal.close') }}</span>
            </button>
        </div>
    </div>
@endif
@if (session('error') or session('error_raw'))
    <div class="alert alert-danger alert-dismissable border-0 shadow-xs mb-5 flex items-center p-4">
        <div class="grow">
            @if (session('error_raw'))
                {!! session('error_raw') !!}
            @else
                {{ session('error') }}
            @endif
        </div>
        <div class="flex-none">
            <button type="button" data-dismiss="alert" aria-hidden="true">
                <i class="fa-solid fa-times" aria-hidden="true"></i>
                <span class="sr-only">{{ __('crud.click_modal.close') }}</span>
            </button>
        </div>
    </div>
@endif
