@extends('layouts.app', [
    'title' => $entity->name . ' - ' . \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'members',
        'view' => 'families.panels._members',
    ])
@endsection
