<?php /** @var \App\Models\Relation $relation */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.relations.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.relations')],
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.relations.update', $campaign, $entity->id, $relation]" method="PATCH" :direct="$from === 'web' ?? null">
        @include('partials.forms.form', [
            'title' => __('entities/relations.update.title', ['name' => '<a href="' .$entity->url() . '">' . $entity->name . '</a>']),
            'content' => 'entities.pages.relations._form',
            'deleteID' => '#delete-relation-' . $relation->id,
        ])
        @if(!empty($from))
            <input type="hidden" name="from" value="{{ $from }}" />
        @endif
        <input type="hidden" name="owner_id" value="{{ $entity->id }}" />
        <input type="hidden" name="option" value="{{ request()->get('option') }}" />
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
    </x-form>

    <x-form method="DELETE" :action="['entities.relations.destroy', 'campaign' => $campaign, 'entity' => $entity->id, 'relation' => $relation->id, 'mode' => request()->mode, 'option' => request()->option]" id="delete-relation-{{ $relation->id }}">
    @if ($relation->isMirrored())<input type="hidden" name="remove_mirrored" value="1" />@endif
        @if (!empty($from)) <input type="hidden" name="from" value="{{ $from }}" /> @endif
    </x-form>
@endsection
