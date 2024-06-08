<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: String,
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="w-full h-[48px] px-4 py-3 rounded-lg border border-[#858C94] appearance-none outline-none bg-transparent placeholder:text-[#000] placeholder:opacity-50 placeholder:text-sm placeholder:font-semibold"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>
