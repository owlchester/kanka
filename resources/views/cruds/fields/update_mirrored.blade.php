<div class="field-mirror">
    {!! Form::hidden('update_mirrored', 0) !!}
    <label>{!! Form::checkbox('update_mirrored', 1)!!}
        {{ __('entities/relations.bulk.update_mirrored') }}
    </label>
</div>
