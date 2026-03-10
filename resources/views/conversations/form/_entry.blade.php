<?php
$targets = [
    \App\Enums\ConversationTarget::users->value => __('conversations.targets.members'),
    \App\Enums\ConversationTarget::characters->value => __('conversations.targets.characters'),
];
?>

<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

    <x-forms.field
        field="participants"
        required
        :label="__('conversations.fields.participants')">
        <x-forms.select name="target_id" :options="$targets" :selected="$source->target_id ?? $model->target_id ?? null" />
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.closed')

    @include('cruds.fields.image')
</x-grid>

