<template>
    <div
        class="bg-white border border-[#F9FBFF] shadow-lg shadow-[rgba(106, 122, 152, 0.15)] rounded-lg flex items-center gap-4 py-4 sm:px-6 px-4 lg:w-[24%] w-full"
    >
        <p
            :class="[
                'flex justify-center items-center p-[10px] rounded-full w-[52px] h-[52px]',
                `${statisticData.bgColorStyle}`,
            ]"
        >
            <FontAwesomeIcon
                size="fa-lg"
                class="flex-shrink-0 h-7 w-7 text-white group-hover:text-white"
                :class="statisticData.icon"
            />
        </p>
        <p class="flex gap-1 flex-col text-[#0F0F14]">
            <span class="font-bold sm:text-md text-sm">{{
                statisticData.name
            }}</span>
            <h1 class="text-[#111827] text-xl font-bold">{{ statisticData.value }}</h1>
        </p>
    </div>
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
        statisticData: {
            type: Object,
            require: true,
            default() {
                return {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#237AE0]",
                    name: "Tous les étudiants",
                    value: 3000,
                };
            },
            validator(value) {
                return (
                    typeof value.icon === "string" &&
                    typeof value.bgColorStyle === "string" &&
                    typeof value.name === "string" &&
                    typeof value.value === "number"
                );
            },
        },
    },
};
</script>
