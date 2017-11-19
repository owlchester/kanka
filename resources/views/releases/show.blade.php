@extends('layouts.app', [
    'title' => trans('releases.show.title', ['name' => $model->title]),
    'description' => '',
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body with-border">

                    @if ($model->image)
                        <img src="/storage/{{ $model->image }}" />
                    @endif

                    {!! $model->body !!}


                </div>
                <div class="box-footer">
                    <a href="{{ route('releases.index') }}">{{ trans('releases.show.return') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
