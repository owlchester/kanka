<template>
    <div>
        <label class="block text-sm mb-2">
            Relationship type
            <select :value="modelValue.type" class="w-full mt-1" @change="update('type', $event.target.value)">
                <option value="partner">Partner</option>
                <option value="parent">Parent / child</option>
            </select>
        </label>
        <label class="block text-sm mb-2">
            Label
            <input :value="modelValue.role" class="w-full mt-1" maxlength="70" placeholder="Former partner, adopted, ..." @input="update('role', $event.target.value)">
        </label>
        <label v-if="modelValue.type === 'parent'" class="block text-sm mb-2">
            Parentage
            <select :value="modelValue.parentage" class="w-full mt-1" @change="update('parentage', $event.target.value)">
                <option value="">Unspecified</option>
                <option value="biological">Biological</option>
                <option value="adoptive">Adoptive</option>
                <option value="foster">Foster</option>
                <option value="step">Step</option>
                <option value="guardian">Guardian</option>
                <option value="other">Other</option>
            </select>
        </label>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['update:modelValue'])

const update = (key, value) => {
    emit('update:modelValue', { ...props.modelValue, [key]: value })
}
</script>
