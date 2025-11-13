<?php
$targets = [
    \App\Enums\ConversationTarget::users->value => __('conversations.targets.members'),
    \App\Enums\ConversationTarget::characters->value => __('conversations.targets.characters'),
];
?>
<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Conversation::class, 'trans' => 'conversations'])

    <x-forms.field
        field="participants"
        :label="__('conversations.fields.participants')">
        <x-forms.select name="target_id" :options="$targets" class="w-full" :selected="$source->target_id ?? $model->target_id ?? null" />
    </x-forms.field>
</x-grid>
