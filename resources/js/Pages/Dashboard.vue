<template>
    <div class="m-4">
        <h1 class="text-[#111827] text-2xl font-bold">Statistiques</h1>
        <div class="flex lg:flex-row flex-col gap-4 w-full py-4 flex-wrap">
            <CardStatistic
                v-for="(item, index) in statisticDataList"
                :key="index"
                :statistic-data="item"
            />
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import CardStatistic from "@/Shared/CardStatistic.vue";

export default {
    components: {
        AppLayout,
        CardStatistic,
    },

    layout: AppLayout,
    data() {
        return {
            statisticDataList: [
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#237AE0]",
                    name: "Tous les étudiants",
                    value: 3000,
                },
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#F57373]",
                    name: "Étudiants en stage",
                    value: 3000,
                },
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#F89500]",
                    name: "Étudiants sans stage",
                    value: 3000,
                },
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#4B9F08]",
                    name: "Etudiants en fin de stage",
                    value: 3000,
                },
                {
                    icon: "fa-light fa-university",
                    bgColorStyle: "bg-[#6733FF]",
                    name: "Les entreprises",
                    value: 5000,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#237AE0]",
                    name: "Toutes les offres",
                    value: 3000,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#F89500]",
                    name: "Offres en cours",
                    value: 3000,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#D70027]",
                    name: "Offres expirées",
                    value: 3000,
                },
            ],
            search: "",
            showFilters: false,
        };
    },
};
</script>
