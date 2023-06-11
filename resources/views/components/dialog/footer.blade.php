<div class="mt-5 flex gap-2 md:gap-5 text-left w-full">
    <div class="grow">
        @if (request()->ajax() || $modal)
            <button type="button" class="btn2 btn-ghost btn-full" data-dismiss="modal">
                {{ __('crud.cancel') }}
            </button>
        @else
            <a href="{{ (!empty($cancel) ? $cancel : url()->previous()) }}" class="btn2 btn-ghost">
                {{ __('crud.cancel') }}
            </a>
        @endif
    </div>
    {!! $slot !!}
</div>
