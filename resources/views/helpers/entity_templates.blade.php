@extends('layouts.app', [
    'title' => __('helpers.entity_templates.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h4>{{ __('helpers.entity_templates.title') }}</h4>
        </div>

        <div class="box-body">
            <p>
                {!! __('helpers.entity_templates.description', [
    'link' => '<code><i class="fa fa-star-o" aria-hidden="true"></i> ' .  __('entities/actions.templates.set') . '</code>',
'action' => '<button class="btn btn-default btn-sm">' . __('crud.actions.actions') . '</button>',
'new' => '<button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> ' . __('crud.new_entity.title') . '</button>',
]) !!}
            </p>
            <p>
                {!! __('helpers.entity_templates.remove', [
    'remove' => '<code><i class="fa fa-star" aria-hidden="true"></i> ' .  __('entities/actions.templates.unset') . '</code>',
    'link' => '<code><i class="fa fa-star-o" aria-hidden="true"></i> ' .  __('entities/actions.templates.set') . '</code>',
]) !!}
            </p>
        </div>
    </div>
@endsection
