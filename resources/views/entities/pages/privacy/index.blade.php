<?php /** @var \App\Models\Entity $entity */?>
@include('partials.forms._dialog', [
    'title' => __('entities/permissions.quick.title', ['name' => $entity->name]) ,
    'content' => 'entities.pages.privacy._body',
    'actions' => 'entities.pages.privacy._footer',
])
