<template>
    <button
        title="Filtrer"
        type="button"
        class="relative flex flex-col rounded-lg border border-[#718096] px-1"
    >
        <div
            class="w-full flex items-center justify-center space-x-2 text-[#718096] h-full"
        >
            <FontAwesomeIcon
                size="fa-lg"
                class="flex-shrink-0 h-4 w-4 fa-light fa-filter"
            />
            <span class="font-bold text-sm leading-6 truncate">Filtrer</span>
        </div>
    </button>
</template>

<script>
import FontAwesomeIcon from "@/Shared/Icons/FontAwesomeIcon.vue";

export default {
    components: {
        FontAwesomeIcon,
    },
};
</script>
