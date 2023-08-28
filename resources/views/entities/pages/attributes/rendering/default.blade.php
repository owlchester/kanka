<?php /** @var \App\Models\Attribute $attribute */?>

@if ($attributes->count() === 0)
    @php return @endphp
@endif
@php
$inSection = false;
@endphp
<x-box css="box-entity-attributes">
<dl class="dl-horizontal">
@foreach ($attributes as $attribute)
    @if ($attribute->isSection())
        </dl>
        @if ($inSection)
            </div></div>
        @endif
        @php
        $inSection = true;
        @endphp
        <div class="rounded shadow-sm mb-5 p-2">
            <h4 class="text-lg cursor-pointer" data-toggle="collapse" data-target="#attribute-section-body-{{ $attribute->id }}">
                @if (auth()->check() && auth()->user()->isAdmin() && $attribute->is_private == true)
                    <i class="fa-solid fa-lock" data-toggle="tooltip" data-title="{{ __('crud.is_private') }}" aria-hidden="true"></i>
                @endif

                {!! $attribute->name() !!}
            </h4>
            <div class="py-2 collapse  !visible in" id="attribute-section-body-{{ $attribute->id }}">
                <dl class="dl-horizontal">
        @continue
    @endif
        <dt>
            <span data-title="{attribute:{{ $attribute->id }}}" data-toggle="tooltip"
                  data-clipboard="{attribute:{{ $attribute->id }}}" data-toast="{{ __('crud.alerts.copy_attribute') }}">
                {!! $attribute->name() !!}
            </span>
            @if (auth()->check() && auth()->user()->isAdmin() && $attribute->is_private == true)
                <i class="fa-solid fa-lock" data-toggle="tooltip" data-title="{{ __('crud.is_private') }}" aria-hidden="true"></i>
            @endif
        </dt>
        <dd>
            @if ($attribute->isCheckbox())
                <span class="live-edit" data-id="{{ $attribute->id }}">
                @if ($attribute->value)
                    <i class="fa-solid fa-check" aria-hidden="true" aria-label="checked"></i>
                @else
                    <i class="fa-solid fa-times" aria-hidden="true" aria-label="unchecked"></i>
                @endif
                </span>
            @elseif ($attribute->isText())
                <span class="live-edit @if (trim($attribute->value) === '') empty-value @endif" data-id="{{ $attribute->id }}">
                    {!! nl2br($attribute->mappedValue()) !!}
                </span>
            @else
                <span class="live-edit @if (trim($attribute->value) === '') empty-value @endif" data-id="{{ $attribute->id }}">
                    {!! $attribute->mappedValue() !!}
                </span>
            @endif

            @if(\App\Facades\Attributes::isLoop($attribute->name))
                <i class="fa-solid fa-warning" data-title="{{ __('entities/attributes.errors.loop') }}" data-toggle="tooltip"></i>
            @endif
        </dd>
@endforeach

@if($inSection)
            </dl>
        </div>
    </div>
@else
    </dl>
@endif
</x-box>
