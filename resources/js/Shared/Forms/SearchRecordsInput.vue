<template>
    <form>
        <FontAwesomeIcon
            size="fa-lg"
            class="flex-shrink-0 h-[23px] w-[23px] text-black fa-light fa-search absolute inset-0 translate-y-3 translate-x-3"
        />
        <input
            id="querySearch"
            ref="searchInputRef"
            type="text"
            class="w-full border border-[#c1bfbf] outline-none bg-[#FAFAFA] h-[50px] pl-12 lg:text-base text-sm font-medium appearance-none rounded-lg"
            :placeholder="inputPlaceholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />
    </form>
</template>

<script>
import { defineAsyncComponent } from "vue";
const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

export default {
    components: {
        FontAwesomeIcon,
    },

    props: {
        modelValue: { type: [String, Number], required: false, default: null },
        inputPlaceholder: {
            type: String,
            required: false,
            default: "Rechercher...",
        },
    },

    expose: ["focus"],

    emits: ["update:modelValue"],

    mounted() {
        if (this.$refs.searchInputRef.hasAttribute("autofocus")) {
            this.$refs.searchInputRef.focus();
        }
    },

    methods: {
        focus() {
            this.$refs.searchInputRef.focus();
        },
    },
};
</script>
