@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($name . '.create.title'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::campaign($campaign)->index($name), 'label' => __('entities.' . $name)],
        __('crud.create'),
    ]
])


@section('content')
    <x-premium-cta :campaign="$campaign">
        <x-slot name="description">
            {{ __('campaigns/limits.' . $key) }}
        </x-slot>
    </x-premium-cta>
@endsection
