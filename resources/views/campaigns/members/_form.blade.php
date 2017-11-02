{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Role:</label>
            {!! Form::select('role', ['owner' => 'Owner', 'member' => 'Member'], ['placeholder' => 'Role', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    or <a href="{{ url()->previous() }}">cancel</a>
</div>
