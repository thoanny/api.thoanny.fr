<template>
    <div class="button-block">
        <!-- Mode édition -->
        <div v-if="isEditing" class="button-block__edit">
            <div>
                <label class="form-control-label required">Libellé</label>
                <input
                    v-model="localTitle"
                    type="text"
                    placeholder=""
                    @keydown.enter.prevent="commit"
                    class="form-control"
                />
            </div>

            <div>
                <label class="form-control-label required">URL</label>
                <input
                    v-model="localUrl"
                    type="url"
                    placeholder="https://..."
                    @keydown.enter.prevent="commit"
                    class="form-control"
                />
            </div>

            <label>
                <input
                    v-model="localNewTab"
                    type="checkbox"
                    class="form-check-input"
                />
                Ouvrir dans une nouvelle fenêtre
            </label>
            <div>
                <button class="btn btn-primary" @click.prevent="commit">
                    Valider
                </button>
            </div>
        </div>

        <!-- Mode aperçu -->
        <div v-else class="button-block__preview">
            <a
                :href="localUrl"
                :target="localNewTab ? '_blank' : '_self'"
                :rel="localNewTab ? 'noopener noreferrer' : null"
                class="btn btn-primary"
                @click.prevent
            >
                {{ localTitle }}
            </a>

            <div class="button-block__meta">
                <span class="button-block__url">{{ localUrl }}</span>
                <span v-if="localNewTab" class="button-block__target"
                    >↗ Nouvelle fenêtre</span
                >
            </div>

            <button
                v-if="!readOnly"
                class="btn btn-secondary"
                @click.prevent="isEditing = true"
            >
                Modifier
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({ title: '', url: '', newTab: false }),
    },
    readOnly: Boolean,
    onUpdate: Function,
});

const isEditing = ref(!props.data.title && !props.data.url);
const localTitle = ref(props.data.title);
const localUrl = ref(props.data.url);
const localNewTab = ref(props.data.newTab);

function commit() {
    const title = localTitle.value.trim();
    const url = localUrl.value.trim();
    const newTab = localNewTab.value;

    if (!title || !url) return;

    props.onUpdate?.({ title, url, newTab });
    isEditing.value = false;
}
</script>

<style scoped>
.button-block {
    font-family: inherit;
    font-size: 0.875rem;
}

.button-block input {
    font-size: var(--font-size-base, 14px);
}

.button-block a.btn {
    text-decoration: none;
}

/* --- Édition --- */
.button-block__edit {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--border-radius, 0.25rem);
    box-shadow: inset 0 0 0 1px var(--form-fieldset-border-color, #eee);
}

/* --- Aperçu --- */
.button-block__preview {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    padding: 4px 0;
}

.button-block__meta {
    display: flex;
    flex-direction: column;
    gap: 2px;
    color: #999;
    flex-grow: 1;
}
</style>
