<template>
    <div class="flex flex-col gap-4">
        <p class="text-neutral-content">{{ i18n.placement }}</p>
        <div class="flex flex-wrap gap-2">
            <button type="button" class="btn2" @click="addSection">{{ i18n.section }}</button>
            <button v-if="config.target !== 'default'" type="button" class="btn2" @click="replace(config.defaultLayout)">{{ i18n.copy }}</button>
            <button type="button" class="btn2" @click="replace(config.standard)">{{ i18n.standard }}</button>
        </div>
        <Draggable v-model="items" tag="ul" class="list-none m-0 p-0 flex flex-col gap-3" data-root="1"
            :group="rootGroup" handle=".sidebar-v2-section-drag, .sidebar-v2-handle" filter="input, button, select, option, a, [data-child-list]" :prevent-on-filter="false" :animation="150">
            <li v-for="(node, index) in items" :key="node.id" :data-section="isSection(node) ? '1' : null" :data-section-id="isSection(node) ? node.id : null"
                class="rounded-lg bg-base-100" :class="{ 'sidebar-v2-section-drag cursor-move': isSection(node) }">
                <SidebarRow :section="isSection(node)" :label="label(node)" :entry="catalog[node.id]" :i18n="i18n" :sections="sections"
                    :removable="removable(node)" @rename="rename(node, $event)" @remove="remove(items, index)"
                    @order="order(items, index, $event)" @move="move(items, index, $event)" />
                <Draggable v-if="isSection(node)" v-model="node.children" tag="ul" data-child-list="1" class="list-none p-3 m-0 min-h-12 flex flex-col gap-2 cursor-auto"
                    :group="childGroup" handle=".sidebar-v2-handle" :animation="150">
                    <li v-for="(child, childIndex) in node.children" :key="child.id" class="rounded-lg bg-base-200">
                        <SidebarRow :entry="catalog[child.id]" :i18n="i18n" :sections="sections" :removable="removable(child)"
                            @remove="remove(node.children, childIndex)" @order="order(node.children, childIndex, $event)"
                            @move="move(node.children, childIndex, $event)" />
                    </li>
                </Draggable>
            </li>
        </Draggable>
        <div>
            <button type="button" class="btn2" @click="addSection">{{ i18n.section }}</button>
        </div>
        <details class="rounded-lg bg-base-200 p-3">
            <summary class="cursor-pointer font-semibold">{{ i18n.addItem }}</summary>
            <div class="flex flex-col gap-3 pt-3">
                <p class="text-neutral-content">{{ i18n.addHelp }}</p>
                <div v-if="available.length" class="flex flex-wrap gap-2">
                    <button v-for="entry in available" :key="entry.id" type="button" class="btn2 btn-sm" @click="add(entry)">
                        {{ i18n.add }}: {{ entry.label }}
                    </button>
                </div>
                <p v-else class="text-neutral-content">{{ i18n.allAdded }}</p>
            </div>
        </details>
        <p v-if="error" role="alert" class="text-error">{{ error }}</p>
        <div class="sticky bottom-4 flex flex-wrap justify-end gap-2">
            <button type="button" class="btn2" :disabled="saving || !dirty" @click="discard">{{ i18n.discard }}</button>
            <button type="button" class="btn2 btn-primary" :disabled="saving" @click="save">{{ saving ? i18n.saving : i18n.save }}</button>
        </div>
    </div>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, ref } from 'vue';
import { VueDraggableNext as Draggable } from 'vue-draggable-next';
import SidebarRow from './SidebarRow.vue';

const props = defineProps({ config: Object });
const config = props.config;
const i18n = config.i18n;
const catalog = Object.fromEntries(config.catalog.map(entry => [entry.id, entry]));
const clone = value => JSON.parse(JSON.stringify(value));
const isSection = node => Array.isArray(node.children);
const clean = nodes => nodes.filter(node => isSection(node) || catalog[node.id]).map(node => {
    if (isSection(node)) node.children = node.children.filter(child => catalog[child.id]);
    return node;
});
const items = ref(clean(clone(config.layout.items)));
const initial = JSON.stringify(items.value);
const dirty = computed(() => JSON.stringify(items.value) !== initial);
const error = ref('');
const saving = ref(false);
const label = node => node.label ?? i18n.sections[node.label_key] ?? node.id;
const sections = computed(() => items.value.filter(isSection).map(node => ({ id: node.id, label: label(node) })));
const used = computed(() => new Set(items.value.flatMap(node => isSection(node) ? node.children.map(child => child.id) : [node.id])));
const available = computed(() => config.catalog.filter(entry => !used.value.has(entry.id)));
const rootGroup = { name: 'sidebar-v2' };
const childGroup = { name: 'sidebar-v2', put: (to, from, element) => element.dataset.section !== '1' };
const removable = node => isSection(node) ? node.id !== 'bookmarks' : !catalog[node.id]?.required;
const rename = (node, value) => { node.label = value; delete node.label_key; };
const addSection = async () => {
    const id = `section-${crypto.randomUUID?.() ?? `${Date.now()}-${Math.random().toString(36).slice(2)}`}`;
    items.value.push({ id, label: i18n.sectionName, children: [] });
    await nextTick();
    const input = document.querySelector(`[data-section-id="${id}"] input`);
    input?.scrollIntoView({ block: 'center', behavior: 'smooth' });
    input?.focus({ preventScroll: true });
    input?.select();
};
const add = entry => items.value.find(node => node.id === 'bookmarks').children.push({ id: entry.id });
const remove = (list, index) => {
    if (!removable(list[index])) return;
    const [node] = list.splice(index, 1);
    if (isSection(node)) items.value.push(...node.children);
};
const order = (list, index, delta) => {
    const destination = index + delta;
    if (destination < 0 || destination >= list.length) return;
    list.splice(destination, 0, list.splice(index, 1)[0]);
};
const move = (list, index, destination) => {
    const target = destination === 'root' ? items.value : items.value.find(node => node.id === destination)?.children;
    if (!target || target === list) return;
    target.push(list.splice(index, 1)[0]);
};
const replace = layout => { items.value = clean(clone(layout.items)); };
const discard = () => { items.value = JSON.parse(initial); error.value = ''; };
const beforeUnload = event => {
    if (dirty.value && !saving.value) { event.preventDefault(); event.returnValue = ''; }
};
window.addEventListener('beforeunload', beforeUnload);
onBeforeUnmount(() => window.removeEventListener('beforeunload', beforeUnload));
const save = async () => {
    saving.value = true;
    error.value = '';
    try {
        const response = await fetch(config.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ action: 'save', target: config.target, revision: config.revision, items: items.value }),
        });
        if (!response.ok) {
            const data = await response.json();
            throw new Error(Object.values(data.errors ?? {}).flat().join(' ') || i18n.error);
        }
        window.location.reload();
    } catch (exception) {
        error.value = exception.message || i18n.error;
        saving.value = false;
    }
};
</script>
