{{ csrf_field() }}
<div class="form-group">
    <label>Name:</label>
    <input type="text" name="name" class="form-control" placeholder="Name of your new campaign">
</div>

<div class="form-group">
    <button class="btn btn-success btn-submit">{{ trans('crud.save' }}</button>
</div>
