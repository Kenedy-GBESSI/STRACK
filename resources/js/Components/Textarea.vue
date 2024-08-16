<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: [String, Number],
});

defineEmits(["update:modelValue"]);

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute("autofocus")) {
        textarea.value.focus();
    }
});

defineExpose({ focus: () => textarea.value.focus() });
</script>

<template>
    <textarea
        ref="textarea"
        class="border-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm min-h-[120px] resize-none"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
    </textarea>
</template>
