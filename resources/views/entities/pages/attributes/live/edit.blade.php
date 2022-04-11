<?php /** @var \App\Models\Attribute $attribute */?>

{!! Form::open(['route' => ['entities.attributes.live.save', $entity, $attribute]]) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">{{ __('entities/attributes.live.title', ['attribute' => $attribute->name]) }}</h4>
</div>
<div class="modal-header">
    <div class="form-group">
        <label for="name">{!! $attribute->name() !!}</label>
    @if ($attribute->isCheckbox())
        <input type="hidden" name="value" value="" />
        <input type="checkbox" name="value" @if($attribute->value) checked="checked" @endif />
    @elseif ($attribute->isText())
        {!! Form::textarea('value', $attribute->value, ['class' => 'form-control', 'rows' => 4]) !!}
    @elseif ($attribute->isBlock())

    @elseif ($attribute->isNumber())
        <input type="number" name="value" class="form-control" maxlength="20" value="{{ $attribute->value }}"
        @if ($attribute->validConstraints()) max="{{ $attribute->numberMax() }}" min="{{ $attribute->numberMin() }}" @endif />
    @elseif ($attribute->validConstraints())
        <select name="value" class="form-control">
            @foreach ($attribute->listRange() as $option)
                <option value="{{ $option }}" @if ($option == $attribute->value) selected="selected" @endif>{{ $option }}</option>
            @endforeach
        </select>
    @else
        <input type="text" name="value" class="form-control" maxlength="191" value="{{ $attribute->value }}" />
    @endif
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">
        <i class="fa-regular fa-save"></i> {{ __('crud.update') }}
    </button>
</div>
{!! Form::hidden('uid', $uid) !!}
{!! Form::close() !!}
