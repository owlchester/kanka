@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/abilities.actions.sync'),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_abilities.index', [$campaign, $entity]), 'label' => __('entities.ability')],
    ],
    'centered' => true,
])

@section('content')
    <x-form method="GET" :action="['entities.entity_abilities.import', $campaign, $entity]">
        @include('partials.forms.form', [
            'title' => __('entities/abilities.actions.sync'),
            'content' => 'entities.pages.abilities._import',
            'submit' => __('entities/abilities.actions.add'),
            'disableSubmit' => empty($races),
        ])
    </x-form>
@endsection
