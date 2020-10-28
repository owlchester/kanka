{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::abilities('abilities', ['exclude' => $entity->id]) !!}
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('cruds.fields.visibility')
            </div>
        </div>
    </div>
</div>
