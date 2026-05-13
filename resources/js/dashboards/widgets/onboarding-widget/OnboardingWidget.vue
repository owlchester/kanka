<template>
    <div v-if="loading" class="flex items-center gap-2 py-4">
        <i class="fa-solid fa-spinner fa-spin"></i>
    </div>

    <div v-else class="flex flex-col gap-6">
        <div class="flex items-center justify-between">
            <span class="widget-title text-lg">{{ i18n['title'] }}</span>
            <span class="text-xs text-neutral-content">{{ state.step }} / 6</span>
        </div>

        <div v-if="state.step === 1" class="flex flex-col gap-4">
            <p class="text-base font-semibold">{{ i18n['step1.heading'] }}</p>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                <button
                    v-for="intent in intents"
                    :key="intent.value"
                    class="flex flex-col gap-1 rounded-lg border border-base-content/20 p-4 text-left transition-colors hover:border-primary hover:bg-base-200 cursor-pointer"
                    :class="{ 'border-primary bg-base-200': selectedIntent === intent.value }"
                    :disabled="savingIntent"
                    @click="selectIntent(intent.value)">
                    <span class="text-sm font-semibold">{{ intent.label }}</span>
                    <span class="text-xs text-neutral-content">{{ intent.description }}</span>
                </button>
            </div>
            <p v-if="savingIntent" class="text-xs text-neutral-content">
                <i class="fa-solid fa-spinner fa-spin mr-1"></i>{{ i18n['step1.saving'] }}
            </p>
        </div>

        <div v-else-if="state.step === 2" class="flex flex-col gap-4">
            <p class="text-base font-semibold">{{ step2Config.heading }}</p>
            <div class="flex gap-2">
                <input
                    v-model="entityName"
                    type="text"
                    class="input input-bordered flex-1"
                    :placeholder="step2Config.placeholder"
                    :disabled="creating"
                    @keyup.enter="createEntity(step2Config.type, 3)" />
                <button
                    class="btn2 btn-primary"
                    :disabled="creating || !entityName.trim()"
                    @click="createEntity(step2Config.type, 3)">
                    <i v-if="creating" class="fa-solid fa-spinner fa-spin mr-1"></i>
                    {{ creating ? i18n['step2.creating'] : i18n['step2.button'] }}
                </button>
            </div>
            <p v-if="createdEntityUrl && createdEntityName" class="text-xs">
                <a :href="createdEntityUrl" class="text-link">{{ i18n['go_to'].replace(':name', createdEntityName ?? '') }}</a>
            </p>
        </div>

        <div v-else-if="state.step === 3" class="flex flex-col gap-4">
            <p class="text-base font-semibold">{{ step3Config.heading }}</p>
            <div class="flex gap-2">
                <input
                    v-model="entityName"
                    type="text"
                    class="input input-bordered flex-1"
                    :placeholder="step3Config.placeholder"
                    :disabled="creating"
                    @keyup.enter="createEntity(step3Config.type, 4)" />
                <button
                    class="btn2 btn-primary"
                    :disabled="creating || !entityName.trim()"
                    @click="createEntity(step3Config.type, 4)">
                    <i v-if="creating" class="fa-solid fa-spinner fa-spin mr-1"></i>
                    {{ creating ? i18n['step3.creating'] : i18n['step3.button'] }}
                </button>
            </div>
            <p v-if="createdEntityUrl && createdEntityName" class="text-xs">
                <a :href="createdEntityUrl" class="text-link">{{ i18n['go_to'].replace(':name', createdEntityName ?? '') }}</a>
            </p>
        </div>

        <div v-else-if="state.step === 4" class="flex flex-col gap-4">
            <p class="text-base font-semibold">{{ i18n['step4.heading'] }}</p>
            <p class="text-sm text-neutral-content">{{ i18n['step4.body'] }}</p>
            <div class="flex gap-3">
                <a :href="step4Url" class="btn2 btn-primary">{{ i18n['step4.cta'] }}</a>
                <button class="btn2" @click="advance(5)">{{ i18n['step4.skip'] }}</button>
            </div>
        </div>

        <div v-else-if="state.step === 5" class="flex flex-col gap-4">
            <p class="text-base font-semibold">{{ step5Config.heading }}</p>
            <p class="text-sm text-neutral-content">{{ step5Config.body }}</p>
            <div class="flex gap-3">
                <a :href="step5Config.ctaUrl" class="btn2 btn-primary">{{ step5Config.cta }}</a>
                <button class="btn2" @click="advance(6)">{{ step5Config.skip }}</button>
            </div>
        </div>

        <div v-else-if="state.step === 6" class="flex flex-col gap-4">
            <p class="text-base font-semibold">{{ i18n['step6.heading'] }}</p>
            <p class="text-sm text-neutral-content">{{ i18n['step6.body'] }}</p>
            <button class="btn2 self-start" @click="dismiss">
                {{ i18n['step6.dismiss'] }}
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'

const props = defineProps<{
    widgetId: string
    stateApi: string
    intentApi: string
    quickCreateApi: string
    progressApi: string
    dismissApi: string
    inviteUrl: string
    entitiesUrls: string
    i18nJson: string
}>()

const i18n = JSON.parse(props.i18nJson) as Record<string, string>
const entityUrls = JSON.parse(props.entitiesUrls) as Record<string, string>

const loading = ref(true)
const savingIntent = ref(false)
const creating = ref(false)
const selectedIntent = ref<string | null>(null)
const entityName = ref('')
const createdEntityUrl = ref<string | null>(null)
const createdEntityName = ref<string | null>(null)

interface WidgetState {
    step: number
    intent: string | null
    entities: number[]
    dismissed: boolean
}

const state = ref<WidgetState>({
    step: 1,
    intent: null,
    entities: [],
    dismissed: false,
})

const intents = computed(() => [
    {
        value: 'campaign',
        label: i18n['step1.campaign'],
        description: i18n['step1.campaign_description'],
    },
    {
        value: 'worldbuilding',
        label: i18n['step1.worldbuilding'],
        description: i18n['step1.worldbuilding_description'],
    },
    {
        value: 'story',
        label: i18n['step1.story'],
        description: i18n['step1.story_description'],
    },
])

const step2Config = computed(() => {
    const intent = state.value.intent
    if (intent === 'worldbuilding') {
        return {
            heading: i18n['step2.worldbuilding_heading'],
            placeholder: i18n['step2.worldbuilding_placeholder'],
            type: 'location',
        }
    }

    return {
        heading: intent === 'campaign' ? i18n['step2.campaign_heading'] : i18n['step2.story_heading'],
        placeholder: intent === 'campaign' ? i18n['step2.campaign_placeholder'] : i18n['step2.story_placeholder'],
        type: 'character',
    }
})

const step3Config = computed(() => {
    const intent = state.value.intent
    if (intent === 'worldbuilding') {
        return {
            heading: i18n['step3.worldbuilding_heading'],
            placeholder: i18n['step3.worldbuilding_placeholder'],
            type: 'organisation',
        }
    }

    return {
        heading: intent === 'campaign' ? i18n['step3.campaign_heading'] : i18n['step3.story_heading'],
        placeholder: intent === 'campaign' ? i18n['step3.campaign_placeholder'] : i18n['step3.story_placeholder'],
        type: 'location',
    }
})

const step4Url = computed(() => {
    const intent = state.value.intent
    if (intent === 'worldbuilding') {
        return entityUrls['location']
    }

    return entityUrls['character']
})

const step5Config = computed(() => {
    const intent = state.value.intent
    if (intent === 'campaign') {
        return {
            heading: i18n['step5.campaign_heading'],
            body: i18n['step5.campaign_body'],
            cta: i18n['step5.campaign_cta'],
            ctaUrl: props.inviteUrl,
            skip: i18n['step5.campaign_skip'],
        }
    }

    const firstEntityUrl = createdEntityUrl.value ?? entityUrls['character']

    return {
        heading: i18n['step5.other_heading'],
        body: i18n['step5.other_body'],
        cta: i18n['step5.other_cta'],
        ctaUrl: firstEntityUrl,
        skip: i18n['step5.other_skip'],
    }
})

onMounted(async () => {
    try {
        const res = await axios.get(props.stateApi)
        state.value = res.data
    } finally {
        loading.value = false
    }
})

async function selectIntent(intent: string): Promise<void> {
    selectedIntent.value = intent
    savingIntent.value = true

    try {
        await axios.post(props.intentApi, { type: intent })
        await axios.post(props.progressApi, { step: 2, intent })
        state.value.intent = intent
        state.value.step = 2
    } finally {
        savingIntent.value = false
    }
}

async function createEntity(type: string, nextStep: number): Promise<void> {
    const name = entityName.value.trim()
    if (!name) {
        return
    }

    creating.value = true
    createdEntityUrl.value = null
    createdEntityName.value = null

    try {
        const res = await axios.post(props.quickCreateApi, { type, name })
        const { id, url, name: entityCreatedName } = res.data
        createdEntityUrl.value = url
        createdEntityName.value = entityCreatedName
        entityName.value = ''
        await advance(nextStep, id)
    } finally {
        creating.value = false
    }
}

async function advance(step: number, entityId?: number): Promise<void> {
    const payload: Record<string, unknown> = { step }
    if (entityId !== undefined) {
        payload['entity_id'] = entityId
    }
    const res = await axios.post(props.progressApi, payload)
    state.value = res.data
}

async function dismiss(): Promise<void> {
    await axios.post(props.dismissApi, { step: state.value.step, widget_id: parseInt(props.widgetId) })
    document.getElementById(`widget-col-${props.widgetId}`)?.remove()
}
</script>
