<?php /** @var \App\Models\QuestElement $element */?>
@extends('layouts.app', [
    'title' => $entity->name . ' - ' . __('quests.show.tabs.elements'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    @include('quests.elements._buttons')
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'elements',
        'view' => 'quests.elements._elements',
    ])
@endsection
