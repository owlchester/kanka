{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        @if (session()->has('campaign_id'))
        <div class="form-group">
            <label>Image:</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
        @endif
    </div>
    @if (session()->has('campaign_id'))
    <!--<div class="col-md-6">
        <div class="form-group">
            <label>Locale:</label>
            {!! Form::text('locale', null, ['placeholder' => 'Language', 'class' => 'form-control']) !!}
        </div>
    </div>-->
    @endif
</div>
@if (session()->has('campaign_id'))
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Description:</label>
            {!! Form::textarea('description', null, ['placeholder' => 'Description', 'class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>
    </div>
</div>
@endif


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    @if (session()->has('campaign_id'))
    or <a href="{{ url()->previous() }}">cancel</a>
    @endif
</div>
