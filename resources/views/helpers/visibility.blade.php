@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('visibilities.helpers.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('visibilities.helpers.title') }}
            </h3>
        </div>

        <div class="box-body">
            <p>{{ __('visibilities.helpers.intro') }}</p>
            <p>{{ __('visibilities.helpers.options') }}</p>
            <dl class="dl-horizontal dl-force-mobile">
                <dt><code>{{ __('crud.visibilities.all') }}</code></dt>
                <dd>{{ __('visibilities.helpers.all') }}</dd>
                <dt><code>{{ __('crud.visibilities.admin') }}</code></dt>
                <dd>{{ __('visibilities.helpers.admin') }}</dd>
                <dt><code>{{ __('crud.visibilities.self') }}</code></dt>
                <dd>{{ __('visibilities.helpers.self') }}</dd>

                <dt><code>{{ __('crud.visibilities.admin-self') }}</code></dt>
                <dd>{!! __('visibilities.helpers.admin-self', ['self' => '<code>' . __('crud.visibilities.self') . '</code>', 'admin' => '<code>' . __('crud.visibilities.admin') . '</code>']) !!}</dd>
                <dt><code>{{ __('crud.visibilities.members') }}</code></dt>
                <dd>{{ __('visibilities.helpers.members') }}</dd>
            </dl>

            <p>{{ __('visibilities.helpers.entities') }}</p>
        </div>
    </div>
@endsection
