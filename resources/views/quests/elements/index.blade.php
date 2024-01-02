<?php /** @var \App\Models\QuestElement $element */?>
@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('quests.show.tabs.elements'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    @include('quests.elements._buttons')
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'elements',
        'breadcrumb' => __('quests.show.tabs.elements'),
        'view' => 'quests.elements._elements',
        'entity' => $model->entity,
    ])
@endsection
