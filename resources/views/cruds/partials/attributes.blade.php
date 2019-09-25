<?php /** @var \App\Models\Attribute $attribute */?>
@php
$inSection = false;
@endphp
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
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#attribute-section-body-{{ $attribute->id }}">
                <h4 class="panel-title">
                    @if (Auth::check() && Auth::user()->isAdmin() && $attribute->is_private === true)
                        <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                    @endif

                    {{ $attribute->name }}
                </h4>
            </div>
            <div class="panel-body collapse in" id="attribute-section-body-{{ $attribute->id }}">
                <dl class="dl-horizontal">
    @endif
        <dt>
            @if (Auth::check() && Auth::user()->isAdmin() && $attribute->is_private === true)
                <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
            @endif
            {{ $attribute->name }}
        </dt>
        <dd>
            @if ($attribute->isCheckbox())
                @if ($attribute->value)
                    <i class="fa fa-check"></i>
                @endif
            @elseif ($attribute->isText())
                {!! nl2br(e($attribute->value)) !!}
            @else
                {{ $attribute->value }}
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