@inject('entities', 'App\Services\EntityService')

{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <p>{{ trans('dashboard.settings.fields.helper') }}</p>

        <div class="form-group required">
            <label>{{ trans('dashboard.settings.fields.recent_count') }}</label>
            {!! Form::select('recent_count', [5 => '5', 9 => 9, 12 => 12], null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">

        <?php $i = 0; ?>
        @foreach ($total = $entities->dashboardEntities() as $entity => $class)
            @if ($i > (count($total) / 2))
    </div>
    <div class="col-md-6">
            @endif
        <div class="form-group">
            <label>
                {!! Form::hidden($entity, 0) !!}
                {!! Form::checkbox($entity) !!}
                {{ trans('entities.' . $entity) }}
            </label>
        </div>
            <?php $i++; ?>
        @endforeach
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>
                {!! Form::hidden('release', 0) !!}
                {!! Form::checkbox('release') !!}
                {{ trans('dashboard.latest_release') }}
            </label>
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
