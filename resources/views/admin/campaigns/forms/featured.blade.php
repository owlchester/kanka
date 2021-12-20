
{{ csrf_field() }}
<div class="form-group checkbox">
    {!! Form::hidden('is_featured', 0) !!}
    <label>
        {!! Form::checkbox('is_featured', 1) !!}
        Featured
    </label>
</div>


<div class="form-group">
    <label>Featured until</label>
    <div class="input-group">
        {!! Form::text('featured_until', null, ['class' => 'form-control datetime-picker', 'maxlength' => 25]) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group">
    <label>Featured reason</label>
    {!! Form::textarea('featured_reason', null, ['placeholder' => 'Why the campaign was featured. HTML works!', 'class' => 'form-control', 'rows' => 3]) !!}
</div>
