@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>{{ trans('partials.errors.title') }}</strong>
        {{ trans('partials.errors.description') }}<br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif