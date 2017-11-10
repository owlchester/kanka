@extends('layouts.app', [
    'title' => trans('releases.index.title'),
    'description' => trans('releases.index.description'),
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @foreach ($models as $model)
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                       {{ $model->title }}
                    </h3>
                </div>

                <div class="box-body">
                    {!! $model->body !!}
                </div>

                <div class="box-footer text-right">
                    {{ trans('releases.post.footer', ['date' => $model->updated_at]) }}
                </div>
            </div>
            @endforeach
            {{ $models->appends('order', request()->get('order'))->links() }}
        </div>
    </div>
@endsection
