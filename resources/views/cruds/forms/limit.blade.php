@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($name . '.create.title'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::campaign($campaign)->index($name), 'label' => __('entities.' . $name)],
        __('crud.create'),
    ]
])


@section('content')
    <x-premium-cta :campaign="$campaign">
        <x-slot name="title">{{ __('campaigns/limits.title') }}</x-slot>
        <p>{{ __('campaigns/limits.pitch', ['limit' => $limit, 'thing' => $thing]) }}</p>
    </x-premium-cta>
@endsection
