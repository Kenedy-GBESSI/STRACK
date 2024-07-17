<template>
    <button
        type="button"
        title="Exporter les données en Excel"
        class="relative flex items-center justify-center gap-2 bg-[#4B5A6E] h-[50px] sm:w-2/3 w-full text-white rounded-md"
        @click.prevent="$emit('exportDataToExcel')"
    >
        <FontAwesomeIcon
            size="fa-lg"
            class="flex-shrink-0 h-5 w-5 fa-light fa-file-download text-white"
        />
        <span class="text-white font-bold text-sm leading-6">Télécharger</span>
    </button>
</template>

<script>
import { Link as InertiaLink } from "@inertiajs/vue3";
import FontAwesomeIcon from "@/Shared/Icons/FontAwesomeIcon.vue";

export default {
    components: {
        InertiaLink,
        FontAwesomeIcon,
    },

    emits: {
        exportDataToExcel: null,
    },
};
</script>
