<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Attribute $attribute
 */
$attributes = $model->entity->starredAttributes;
?>
@if (count($attributes) > 0)
    @foreach ($attributes as $attribute)
        <li class="list-group-item @if ($attribute->isSection()) text-center @endif">
            @if ($attribute->isCheckbox())
                @if ($attribute->value)
                    <i class="fa fa-check pull-right"></i>
                @else
                    <span class="pull-right">{{ __('voyager.generic.no') }}</span>
                @endif
            @endif
            <strong title="{{ __('crud.attributes.fields.is_star') }}">{{ $attribute->name }}</strong>
            @if ($attribute->isText())
                <p>{!! nl2br($attribute->mappedValue()) !!}</p>
            @elseif (!$attribute->isCheckbox())
                <span class="pull-right">{!! $attribute->mappedValue() !!}</span>
                <br class="clear" />
            @endif
        </li>
    @endforeach
@endif
