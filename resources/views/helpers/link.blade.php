@extends('layouts.app', [
    'title' => trans('helpers.title'),
    'description' => trans('helpers.description'),
    'breadcrumbs' => [
        trans('helpers.link.title')
    ]
])

@inject('linker', 'App\Services\LinkerService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    {{ trans('helpers.link.title') }}
                </div>

                <div class="box-body">
                    <p>
                        {{ trans('helpers.link.description') }}
                    </p>
                    <ul>
                        @foreach ($linker->elements() as $element)
                        <li>
                            {{ trans('helpers.link.elements.'.$element) }}:
                            <code>{{ '{' . $element }}:name}</code>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
