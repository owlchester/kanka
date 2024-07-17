<?php /** @var \App\Models\Attribute $attribute */?>

<x-form :action="['entities.attributes.live.save', $campaign, $entity, $attribute]" class="live-attribute-form" direct>
    @include('partials.forms.form', [
            'title' =>__('entities/attributes.live.title', ['attribute' => $attribute->name()]),
            'content' => 'entities.pages.attributes.live._form',
            'submit' => __('crud.update'),
            'dialog' => true,
            'dropdownParent' => '#primary-dialog',
        ])
    @if (!empty($uid))<input type="hidden" name="uid" value="{{ $uid }}" />@endif
</x-form>
