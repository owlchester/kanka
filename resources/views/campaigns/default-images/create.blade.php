@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('campaigns/default-images.create.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign.default-images'), 'label' => trans('campaigns/default-images.index.title')]
    ]
])

@section('content')
    <div class="panel panel-default">
        {!! Form::open([
            'route' => ['campaign.default-images.store'],
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
        ]) !!}
        <div class="panel-body">
            @include('partials.errors')

            <div class="form-group required">
                <label>{{ trans('crud.fields.entity_type') }}</label>
                {!! Form::select('entity_type', $entities, [], ['class' => 'form-control']) !!}
            </div>


            {!! Form::file('default_entity_image', ['class' => 'image form-control']) !!}
        </div>
        <div class="panel-footer">
            <button class="btn btn-success">{{ trans('crud.save') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
        </div>
    </div>

    {{ csrf_field() }}
    {!! Form::close() !!}
@endsection
