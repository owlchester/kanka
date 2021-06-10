<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\QuestElement $element
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/quests.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.quests')
    ],
    'mainTitle' => false,
    'canonical' => true,
    'miscModel' => $entity->child,
])
@inject('campaign', 'App\Services\CampaignService')


@include('entities.components.header', ['model' => $entity->child, 'entity' => $entity])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include($entity->pluralType() . '._menu', ['active' => 'quests', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-10">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ __('entities/quests.title', ['name' => $entity->name]) }}
                    </h2>

                    <p class="help-block">{{ __('entities/quests.helper') }}</p>

                    <table id="entity-map-points" class="table table-hover {{ $data->count() === 0 ? 'export-hidden' : '' }}">
                        <tbody><tr>
                            <th class="avatar"></th>
                            <th>{{ __('quests.elements.fields.quest') }}</th>
                            <th>{{ __('quests.fields.role') }}</th>
                            <th>{{ __('quests.fields.type') }}</th>
                            <th>{{ __('quests.fields.is_completed') }}</th>
                        </tr>
                        @foreach ($quests as $element)
                            <tr>
                                <td>
                                    <a class="entity-image" style="background-image: url('{{ $element->quest->getImageUrl(40) }}');" title="{{ $element->quest->name }}" href="{{ route('quests.show', $element->quest_id) }}"></a>
                                </td>
                                <td>
                                    {!! $element->quest->tooltipedLink() !!}
                                </td>
                                <td>
                                    {{ $element->role }}
                                </td>
                                <td>
                                    {{ $element->quest->type }}
                                </td>
                                <td>
                                    @if($element->quest->is_completed)
                                        <i class="fas fa-check-circle"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $quests->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
