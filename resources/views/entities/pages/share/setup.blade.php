@php
    $shareTranslations = [
        'status_hidden'          => __('entities/share.status.hidden'),
        'helper_hidden'          => __('entities/share.helpers.hidden_explanation'),
        'helper_hidden_unlisted' => __('entities/share.helpers.hidden_unlisted_explanation'),
        'status_public'          => __('entities/share.status.public'),
        'helper_public'          => __('entities/share.helpers.public_explanation'),
        'status_unlisted'        => __('entities/share.status.unlisted'),
        'helper_unlisted'        => __('entities/share.helpers.unlisted_explanation'),
        'status_private'         => __('entities/share.status.private'),
        'helper_private'         => __('entities/share.helpers.private_explanation'),
        'warning_entity_permissions' => __('entities/share.helpers.entity_permissions_warning'),

        'field_visibility_mode'  => __('entities/share.fields.visibility_mode'),
        'helper_visibility_mode' => __('entities/share.helpers.visibility_mode'),
        'option_entity_public'   => __('entities/share.options.make_entity_public', ['name' => $entity->name]),
        'option_global_public'   => __('entities/share.options.make_all_public', ['module' => $entity->entityType->plural()]),

        'field_campaign_access'  => __('entities/share.fields.campaign_access'),
        'helper_campaign_access' => __('entities/share.helpers.campaign_access'),

        'label_member_link'      => __('entities/share.labels.member_link'),
        'label_public_link'      => __('entities/share.labels.public_link'),
        'btn_save'               => __('crud.actions.save-changes'),
        'btn_make_public'        => __('entities/share.buttons.make_public'),
        'btn_copy'               => __('entities/share.buttons.copy'),
        'btn_close'              => __('crud.actions.close'),
        'success_copied_public'  => __('entities/share.success.copied_public'),
        'success_copied_members' => __('entities/share.success.copied_members'),
        'success_updated'        => __('entities/share.success.updated'),
        'error_generic'          => __('errors.500.body.1'),
        'title'                  => __('entities/share.title'),
    ];
@endphp

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/share.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('entities/share.title')
    ]
])

@section('content')

<div id="entity-share-container">
    <entity-share-modal
        initial-campaign-visibility="{{ $campaign->visibility_id->name }}"
        :initial-entity-private="{{ $entity->is_private ? 'true' : 'false' }}"
        url="{{ $entity->url() }}"
        save-endpoint="{{ route('entities.share.save', [$campaign, $entity]) }}"
        :trans='@json($shareTranslations)'
    ></entity-share-modal>
</div>

@endsection

