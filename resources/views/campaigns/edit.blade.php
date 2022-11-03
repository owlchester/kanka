@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => __('entities.campaign')],
        trans('crud.edit')
    ],
    'canonical' => true,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('fullpage-form')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data',
        'route' => ['campaigns.update', $model->id],
        'data-shortcut' => '1',
        'class' => 'entity-form',
    ]) !!}
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))

    @if(!empty($model) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('campaigns.keep-alive', $model->id) }}" />
    @endif
@endsection


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@inject('campaignService', 'App\Services\CampaignService')
@include('editors.editor')

@section('modals')
    @parent
    @if(!empty($editingUsers) && !empty($model))
        <div class="modal" id="entity-edit-warning" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">{{ __('entities/story.warning.editing.title') }}</h4>
                    </div>
                    <div class="modal-body modal-ajax-body">
                        <p>
                            {{ __('campaigns.warning.editing.description') }}
                        </p>
                        <ul>
                            @foreach ($editingUsers as $user)
                                <li class="user-id-{{ $user->id }}">{{ __('entities/story.warning.editing.user', ['user' => $user->name, 'since' => \Carbon\Carbon::createFromTimeString($user->pivot->created_at)->diffForHumans()]) }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-body modal-spinner-body text-center" style="display: none">
                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" id="entity-edit-warning-back" data-url="{{ url()->previous() }}">
                            {{ __('entities/story.warning.editing.back') }}
                        </button>
                        <button type="button" class="btn btn-warning" id="entity-edit-warning-ignore" data-url="{{ route('campaigns.confirm-editing', $model) }}">
                            {{ __('entities/story.warning.editing.ignore') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection