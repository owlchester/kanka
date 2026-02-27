@php
    $shareTranslations = [
        'title'                  => __('campaigns/share.title'),
        'status_private'         => __('campaigns/share.status.private'),
        'status_public'          => __('campaigns/share.status.public'),
        'status_unlisted'        => __('campaigns.visibilities.titles.unlisted'),
        'helper_private'         => __('campaigns/share.helpers.private_explanation'),
        'helper_public'          => __('campaigns/share.helpers.public_explanation'),
        'helper_unlisted'        => __('campaigns/share.helpers.unlisted_explanation'),
        'label_member_link'      => __('campaigns/share.labels.member_link'),
        'label_public_link'      => __('campaigns/share.labels.public_link'),
        'btn_make_public'        => __('campaigns/share.buttons.make_public'),
        'btn_copy_public_link'   => __('campaigns/share.buttons.copy_public_link'),
        'btn_change_visibility'  => __('campaigns/share.buttons.change_visibility'),
        'btn_copy'               => __('campaigns/share.buttons.copy'),
        'btn_close'              => __('crud.actions.close'),
        'success_copied_public'  => __('campaigns/share.success.copied_public'),
        'success_copied_members' => __('campaigns/share.success.copied_members'),
        'error_generic'          => __('errors.500.body.1'),
    ];
@endphp

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/share.title'),
])

@section('content')

<div id="campaign-share-container">
    <campaign-share-modal
        initial-visibility="{{ $campaign->visibility_id->name }}"
        url="{{ route('dashboard', $campaign) }}"
        save-endpoint="{{ route('campaign.share.save', $campaign) }}"
        settings-url="{{ route('campaign-visibility', $campaign) }}"
        :trans='@json($shareTranslations)'
    ></campaign-share-modal>
</div>

@endsection
