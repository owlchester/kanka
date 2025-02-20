<?php
/** @var \App\Models\Attribute $attribute */
$inSection = false;
if ($attributes->count() === 0) {
    return;
}
$sections = \App\Facades\Attributes::organise($attributes);
$uid = 1;
?>

<div class="box-entity-attributes flex flex-col gap-5 max-w-7xl">
@foreach ($sections as $section)
    <div class="rounded p-2 flex flex-col gap-2 bg-base-100">
        <div class="flex items-center gap-5 text-lg cursor-pointer p-2" data-animate="collapse" data-target="#attribute-section-body-{{ $section['id'] }}">
            <div class="section-name grow">
                @if (!empty($section['id']))
                    @if (auth()->check() && auth()->user()->isAdmin() && $section['is_private'] == true)
                        <i class="fa-solid fa-lock" data-toggle="tooltip" data-title="{{ __('crud.is_private') }}" aria-hidden="true"></i>
                    @endif
                    {!! $section['name'] !!}
                @else
                    {{ __('entities/attributes.sections.unorganised') }}
                @endif
            </div>
            <div class="flex-none">
                <x-icon class="fa-solid fa-chevron-up collapsed:flip transition-all duration-150" />
            </div>
        </div>
        <div class="section-attributes overflow-hidden flex flex-col gap-1" id="attribute-section-body-{{ $section['id'] }}">
            @foreach ($section['attributes'] as $attribute)
                <div class="flex items-center gap-5 w-full p-1 rounded-2xl odd:bg-base-200">
                    <div class="attribute-icon w-8 p-2 text-accent">
                        @if ($attribute->isNumber())
                            <x-icon class="fa-solid fa-hashtag" />
                        @elseif ($attribute->isCheckbox())
                            <x-icon class="fa-solid fa-user-check" />
                        @else
                            <x-icon class="fa-solid fa-circle-notch" />
                        @endif
                    </div>
                    <div class="flex flex-col gap-1 p-2 w-full">
                        <div class="attribute-name">
                            <div class="cursor-pointer inline-block" data-title="{attribute:{{ $attribute->id }}}" data-toggle="tooltip"
                            data-clipboard="{attribute:{{ $attribute->id }}}"
                            data-toast="{{ __('crud.alerts.copy_attribute') }}">
                                @if (auth()->check() && auth()->user()->isAdmin() && $attribute->is_private)
                                    <x-icon class="fa-solid fa-lock" tooltip :title="__('crud.is_private')" />
                                @endif
                                @if ($attribute->validConstraints())
                                    <span class="font-extrabold">{!! $attribute->name() !!}</span>
                                @else
                                    <span class="font-extrabold">{!! $attribute->name() !!}</span>
                                @endif
                            </div>
                        </div>
                        <div class="attribute-value grow" data-live-id="{{ $attribute->id }}">
                            @if ($attribute->isCheckbox())
                                @if ($attribute->value)
                                    <x-icon class="fa-solid fa-check" label="checked" />
                                @else
                                    <x-icon class="fa-solid fa-xmark" label="unchecked" />
                                @endif
                            @elseif ($attribute->isText())
                                {!! nl2br($attribute->mappedValue()) !!}
                            @else
                                {!! $attribute->mappedValue() !!}
                            @endif

                            @if(\App\Facades\Attributes::isLoop($attribute->name))
                                <x-icon class="fa-solid fa-warning" title="{{ __('entities/attributes.errors.loop') }}" tooltip />
                            @endif
                        </div>
                    </div>
                    @if (!isset($fromDashboard) || !$fromDashboard)
                        @can('update', $entity)
                            <div class="flex-none p-2">
                                <a href="{{ route('entities.attributes.live.edit2', [$campaign, $entity, $attribute, 'uid' => $uid++]) }}" data-toggle="dialog" data-url="{{ route('entities.attributes.live.edit2', [$campaign, $entity, $attribute, 'target' => '[data-live-id=' . $attribute->id . ']', 'uid' => $uid++]) }}" data-target="primary-dialog" title="{{ __('crud.edit') }}">
                                    <x-icon class="fa-regular fa-pen-to-square" />
                                </a>
                            </div>
                            @endcan
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endforeach

</div>
