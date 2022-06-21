<p>
<div class="form-group">
    {!! Form::hidden('update_mirrored', 0) !!}
    <label>{!! Form::checkbox('update_mirrored', 1)!!}
        {{ __('entities/relations.bulk.update_mirrored') }}
    </label>
</div>
</p>
