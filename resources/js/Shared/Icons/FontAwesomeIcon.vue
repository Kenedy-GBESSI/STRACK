<template>
    <i :class="size"></i>
</template>

<script>
import "@/Fontawesome/light.min.js";
import "@/Fontawesome/fontawesome.min.js";

export default {
    props: {
        size: {
            type: String,
            default: "fa-lg",
        },
    },
};
</script>
