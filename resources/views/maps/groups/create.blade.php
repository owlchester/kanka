<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapGroup $model
*/
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
'title' => __('maps/groups.create.title', ['name' => $map->name]),
'description' => '',
'breadcrumbs' => [
['url' => route('maps.index'), 'label' => __('maps.index.title')],
['url' => $map->entity->url('show'), 'label' => $map->name],
__('maps/groups.create.title')
]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('maps/groups.create.title', ['name' => $map->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')
            {!! Form::open(['route' => ['maps.map_groups.store', $map], 'method' => 'POST', 'data-shortcut' => 1]) !!}
                @include('maps.groups._form', ['model' => null, 'map' => $map])
                <div class="pull-right">
                    <div class="form-group">
                        <div class="btn-group">
                            <input id="submit-mode" type="hidden" value="true"/>
                            <button class="btn btn-success" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">
                                {{ __('crud.save') }}
                            </button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <button type="submit" name="submit" value="save" class="dropdown-item">
                                        {{ __('crud.save') }}
                                    </button>
                                </li>
                                <li>
                                    <button type="submit" name="submit" value="update" class="dropdown-item">
                                        {{ __('crud.save_and_update') }}
                                    </button>
                                </li>
                                <li>
                                    <button type="submit" name="submit" value="new" class="dropdown-item">
                                        {{ __('crud.save_and_new') }}
                                    </button>
                                </li>
                                <li>
                                    <button type="submit" name="submit" value="explore" class="dropdown-item">
                                        {{ __('maps/markers.actions.save_and_explore') }}  
                                    </button>
                                </li>
                            </ul>
                            <div class="submit-animation" style="display: none;">
                                <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
                            </div>
                        </div>
                        @includeWhen(!request()->ajax(), 'partials.or_cancel')
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
