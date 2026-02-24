<div class="alert p-4 @if ($type) alert-{{ $type }}  @else alert-info @endif tutorial rounded-2xl" id="{{ $id }}">
    @auth
    <button type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none float-right" data-dismiss="tutorial" data-target="#{{ $id }}" aria-hidden="true" data-url="{{ route('tutorials.dismiss', ['code' => $code]) }}">
        <x-icon class="fa-regular fa-circle-xmark" tooltip="1" title="{{ __('crud.actions.close') }}" />
    </button>
    @endauth
    <div class="flex flex-col gap-2">
        @if (!empty($title))
            <p class="text-lg font-semibold">
                {!! $title !!}
            </p>
        @endif
        {!! $slot !!}
        @if (!empty($doc))
            <a href="{{ $doc }}" class="text-link">
                <x-icon class="fa-regular fa-book" />
                {{ __('general.documentation') }}
            </a>
        @endif
    </div>
</div>
