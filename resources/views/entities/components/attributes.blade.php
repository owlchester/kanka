<?php
/**
 * @var \App\Models\Attribute $attribute
 */
$attributes = $entity->starredAttributes();
?>
@if (count($attributes) > 0)
    @foreach ($attributes as $attribute)
        <div class="pinned-attribute flex gap-2 flex-wrap @if ($attribute->isSection()) border-t pinned-attribute-section text-center @elseif ($attribute->value == null) pinned-attribute-empty @endif" data-attribute="{{ $attribute->name }}" data-target="{{ $attribute->id }}" @if ($attribute->is_private) data-private="true" @endif>
            <strong>
                {!! $attribute->name() !!}
            </strong>
            @if ($attribute->isCheckbox())
                <span class="live-edit grow text-right" data-id="{{ $attribute->id }}">
                @if ($attribute->value)
                    <x-icon class="fa-solid fa-check " />
                @else
                    <span class="">
                        {{ __('general.no') }}
                    </span>
                @endif
                </span>
            @elseif ($attribute->isText())
                <p class="m-0 grow w-full live-edit @if (trim($attribute->value) === '') empty-value @endif" data-id="{{ $attribute->id }}">
                    {!! nl2br($attribute->mappedValue()) !!}
                </p>
            @elseif (!$attribute->isCheckbox() && !$attribute->isSection())
                <p class="live-edit @if (trim($attribute->value) === '') empty-value @endif text-right grow m-0 inline-block" data-id="{{ $attribute->id }}">
                    {!! $attribute->mappedValue() !!}
                </p>
            @endif
        </div>
    @endforeach
    <input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />
@endif

@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

@section('modals')
    @parent
    <x-dialog id="live-attribute-dialog" :loading="true"></x-dialog>
@endsection
