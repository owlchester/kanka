<?php
$targets = [
    \App\Models\Conversation::TARGET_USERS => __('conversations.targets.members'),
    \App\Models\Conversation::TARGET_CHARACTERS => __('conversations.targets.characters'),
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
