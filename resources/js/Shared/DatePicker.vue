<template>
    <div :class="$attrs.class">
        <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
        <FlatPickr
            :id="id"
            v-bind="{ ...$attrs, class: null }"
            v-model="value"
            :config="config"
            class="w-full h-[48px] px-4 py-3 rounded-lg border border-[#858C94] appearance-none outline-none bg-transparent placeholder:text-[#000] placeholder:opacity-50 placeholder:text-sm placeholder:font-semibold"
            :class="{ error: error }"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <div v-if="error" class="form-error text-red-600">{{ error }}</div>
    </div>
</template>

<script>
import { v4 as uuid } from "uuid";
import FlatPickr from "vue-flatpickr-component";
import fp from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import { French } from "flatpickr/dist/l10n/fr.js";

export default {
    components: {
        FlatPickr,
    },

    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${uuid()}`;
            },
        },

        error: String,
        label: String,
        modelValue: String,
    },

    emits: ["update:modelValue"],
    data() {
        return {
            value: null,
            config: {
                altInput: true,
                altFormat: "d/m/Y",
                dateFormat: "Y-m-d",
                locale: French,
            },

            flatpickrInstance: null,
        };
    },

    mounted() {
        this.initializeFlatpickr();
    },

    methods: {
        initializeFlatpickr() {
            this.flatpickrInstance = fp(`#${this.id}`, this.config);
        },

        focus() {
            this.flatpickrInstance.open();
        },

        select() {
            this.$refs.input.select();
        },

        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end);
        },
    },
};
</script>
