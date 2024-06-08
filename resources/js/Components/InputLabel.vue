<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <label class="font-medium text-sm leading-[140%]">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
