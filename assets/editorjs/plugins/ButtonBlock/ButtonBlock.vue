<template>
    <div class="button-block">
        <!-- Mode édition -->
        <div v-if="isEditing" class="button-block__edit">
            <div class="button-block__field">
                <label>Libellé</label>
                <input
                    v-model="localTitle"
                    type="text"
                    placeholder="ex. Voir le projet"
                    @keydown.enter.prevent="commit"
                />
            </div>

            <div class="button-block__field">
                <label>URL</label>
                <input
                    v-model="localUrl"
                    type="url"
                    placeholder="https://..."
                    @keydown.enter.prevent="commit"
                />
            </div>

            <label class="button-block__checkbox">
                <input v-model="localNewTab" type="checkbox" />
                Ouvrir dans une nouvelle fenêtre
            </label>

            <button class="button-block__validate" @click.prevent="commit">
                ✓ Valider
            </button>
        </div>

        <!-- Mode aperçu -->
        <div v-else class="button-block__preview">
            <a
                :href="localUrl"
                :target="localNewTab ? '_blank' : '_self'"
                :rel="localNewTab ? 'noopener noreferrer' : null"
                class="button-block__cta"
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
                class="button-block__edit-btn"
                @click.prevent="isEditing = true"
            >
                ✎ Modifier
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
}

/* --- Édition --- */
.button-block__edit {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px;
    border: 1px solid #ddd;
}
.button-block__field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.button-block__field label {
    font-size: 12px;
    font-weight: 500;
    color: #888;
}
.button-block__field input {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 7px 10px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.15s;
}
.button-block__field input:focus {
    border-color: #555;
}
.button-block__checkbox {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    cursor: pointer;
    user-select: none;
}
.button-block__validate {
    align-self: flex-start;
    padding: 6px 14px;
    border-radius: 6px;
    border: none;
    background: #1a73e8;
    color: #fff;
    font-size: 13px;
    cursor: pointer;
}
.button-block__validate:hover {
    background: #1558b0;
}

/* --- Aperçu --- */
.button-block__preview {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    padding: 4px 0;
}
.button-block__cta {
    display: inline-flex;
    align-items: center;
    padding: 9px 20px;
    border-radius: 6px;
    background: #1a73e8;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    pointer-events: none;
}
.button-block__meta {
    display: flex;
    flex-direction: column;
    gap: 2px;
    font-size: 12px;
    color: #999;
}
.button-block__edit-btn {
    padding: 5px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: transparent;
    font-size: 12px;
    cursor: pointer;
    margin-left: auto;
}
.button-block__edit-btn:hover {
    border-color: #999;
}
</style>
