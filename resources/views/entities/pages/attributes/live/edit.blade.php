<?php /** @var \App\Models\Attribute $attribute */?>

{!! Form::open(['route' => ['entities.attributes.live.save', $campaign, $entity, $attribute]]) !!}
@include('partials.forms.form', [
        'title' =>__('entities/attributes.live.title', ['attribute' => $attribute->name()]),
        'content' => 'entities.pages.attributes.live._form',
        'submit' => __('crud.update'),
        'dialog' => true,
        'dropdownParent' => '#primary-dialog',
    ])
{!! Form::hidden('uid', $uid) !!}
{!! Form::close() !!}
