@extends('layouts.app', [
    'title' => __('helpers.troubleshooting.title'),
    'breadcrumbs' => false,
])

@section('content')
    {!! Form::open(['route' => 'troubleshooting.generate', 'method' => 'POST']) !!}

    @include('partials.errors')
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4>{{ __('helpers.troubleshooting.subtitle') }}</h4>
                </div>

                <div class="box-body">
                    <p>
                        {{ __('helpers.troubleshooting.description') }}
                    </p>

                    @if($token)
                        <div class="alert alert-success">
                            <p>{{ __('helpers.troubleshooting.success') }}</p>
                            <strong>{{ $token }}</strong>
                        </div>
                    @else

                    <div class="form-group">
                        {!! Form::select('campaign', $campaigns, null, ['class' => 'form-control']) !!}
                    </div>
                    @endif

                </div>

                @if(!$token)
                <div class="box-footer text-right">
                    <input type="submit" class="btn btn-primary" value="{{ __('helpers.troubleshooting.save_btn') }}" />
                </div>
                @endif
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
