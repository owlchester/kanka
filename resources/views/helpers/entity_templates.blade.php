@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('helpers.entity_templates.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            @if (request()->ajax())
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            @endif
            <h4 class="box-title">{{ __('helpers.entity_templates.title') }}</h4>

        </div>

        <div class="box-body">
            <p>
                {!! __('helpers.entity_templates.description', [
    'link' => '<code><i class="fa-solid fa-star" aria-hidden="true"></i> ' .  __('entities/actions.templates.set') . '</code>',
'action' => '<i class="fa-solid fa-cog"></i>',
'new' => '<button class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> ' . __('crud.new_entity.title') . '</button>',
]) !!}
            </p>
            <p>
                {!! __('helpers.entity_templates.remove', [
    'remove' => '<code><i class="fa-solid fa-star-o" aria-hidden="true"></i> ' .  __('entities/actions.templates.unset') . '</code>',
    'link' => '<code><i class="fa-solid fa-star" aria-hidden="true"></i> ' .  __('entities/actions.templates.set') . '</code>',
]) !!}
            </p>
        </div>
    </div>
@endsection
