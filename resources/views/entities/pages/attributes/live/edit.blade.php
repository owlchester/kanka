<?php /** @var \App\Models\Attribute $attribute */?>

{!! Form::open(['route' => ['entities.attributes.live.save', $entity, $attribute]]) !!}
<div class="modal-header">
    <x-dialog.close />
    <h4 class="modal-title" id="myModalLabel">{!! __('entities/attributes.live.title', ['attribute' => $attribute->name()]) !!}</h4>
</div>
<div class="modal-header">
    <div class="form-group">
        <label for="name">{!! $attribute->name() !!}</label>
    @if ($attribute->isCheckbox())
        <input type="hidden" name="value" value="" />
        <input type="checkbox" name="value" @if($attribute->value) checked="checked" @endif />
    @elseif ($attribute->isText())
        {!! Form::textarea('value', $attribute->value, ['class' => 'form-control', 'rows' => 4]) !!}
    @elseif ($attribute->isNumber())
        <input type="number" name="value" class="form-control" maxlength="20" value="{{ $attribute->value }}"
        @if ($attribute->validConstraints()) max="{{ $attribute->numberMax() }}" min="{{ $attribute->numberMin() }}" @endif />
    @elseif ($attribute->validConstraints())
        <select name="value" class="form-control">
            @foreach ($attribute->listRange() as $option)
                <option value="{{ $option }}" @if ($option == $attribute->value) selected="selected" @endif>{{ \App\Facades\Mentions::onlyName()->mapText($option) }}</option>
            @endforeach
        </select>
        <p class="help-block">{{ __('entities/attributes.ranges.text', ['options' => $attribute->listRangeText()]) }}</p>
    @else
        <input type="text" name="value" class="form-control" maxlength="191" value="{{ $attribute->value }}" />
    @endif
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn2 btn-primary">
        <x-icon class="fa-regular fa-save"></x-icon>
        {{ __('crud.update') }}
    </button>
</div>
{!! Form::hidden('uid', $uid) !!}
{!! Form::close() !!}
