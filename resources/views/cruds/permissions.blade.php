@extends('layouts.app', [
    'title' => trans('crud.permissions.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($entity->pluralType() . '.index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => route($entity->pluralType() . '.show', $entity->child->id), 'label' => $entity->name],
        trans('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    @include('cruds.panels.permissions')
@endsection