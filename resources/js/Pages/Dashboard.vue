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
        <div class="flex flex-wrap mt-1.5 sm:mr-3">
            <div class="sm:w-8/12 mr-0 w-full bg-[#fff] p-4 rounded-lg">
                <div class="w-full flex justify-between sm:h-[30px] flex-wrap">
                    <div
                        class="flex items-center border-b border-[#c2c2c22a] sm:w-3/4 w-full"
                    >
                        <p
                            v-for="(item, index) in [
                                'Sont en stage',
                                'Ont fini les stages',
                            ]"
                            :key="index"
                            class="h-full w-1/2 flex justify-center items-center cursor-pointer text-[#030229]"
                            :class="[
                                indicator == index
                                    ? 'border-b-2 border-[#061A53] font-bold text-lg'
                                    : 'text-base font-normal',
                            ]"
                            @click.prevent="currentLine(index)"
                        >
                            {{ item }}
                        </p>
                    </div>
                    <select class="text-xs rounded" name="" id="">
                        <option value="1">Vue Mois</option>
                    </select>
                </div>
                <div class="flex h-[50vh] w-full pt-8">
                    <div class="w-full h-full">
                        <Chart :options="chartOptions" class="h-full w-full" />
                    </div>
                </div>
            </div>
            <div class="sm:w-4/12 w-full sm:mt-0 mt-4 sm:pl-6 pl-0">
                <div class="w-full p-4 rounded-lg bg-[#fff]">
                    <div
                        class="w-full flex justify-between sm:h-[30px] flex-wrap"
                    >
                        <div
                            class="flex items-center border-b border-[#c2c2c22a] sm:w-3/4 w-full"
                        >
                            <p
                                class="flex justify-center items-center cursor-pointer text-[#030229]"
                            >
                                Étudiants
                            </p>
                        </div>
                    </div>
                    <div class="flex h-[50vh] w-full pt-8">
                        <div class="w-full h-full">
                            <Chart
                                :options="chartOptionsPie"
                                class="h-full w-full"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import CardStatistic from "@/Shared/CardStatistic.vue";
import { Chart } from "highcharts-vue";

export default {
    components: {
        AppLayout,
        CardStatistic,
        Chart,
    },

    layout: AppLayout,
    props: {
        data: {
            type: Object,
            default() {
                return {};
            },
        },
    },

    data() {
        return {
            indicator: 0,
            totalStudents: this.data?.all_students ?? 0,
            chartOptionsPie: {
                chart: {
                    type: "pie",
                    custom: {
                        totalStudents: this.data.all_students,
                    },
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;
                            const totalStudents = chart.options.chart.custom.totalStudents ?? 0;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer
                                        .label(
                                            `Tous les étudiants<br/><strong>${totalStudents}</strong>`,
                                        )
                                        .css({
                                            color: "#000",
                                            textAnchor: "middle",
                                        })
                                        .add();
                            }

                            const x = series.center[0] + chart.plotLeft,
                                y =
                                    series.center[1] +
                                    chart.plotTop -
                                    customLabel.attr("height") / 2;

                            customLabel.attr({
                                x,
                                y,
                            });
                            // Set font size based on chart diameter
                            customLabel.css({
                                fontSize: `${series.center[2] / 12}px`,
                            });
                        },
                    },
                },
                accessibility: {
                    point: {
                        valueSuffix: "%",
                    },
                },
                title: {
                    text: "",
                },
                tooltip: {
                    pointFormat:
                        "{series.name}: <b>{point.percentage:.0f}%</b>",
                },
                legend: {
                    enabled: false,
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: "pointer",
                        borderRadius: 8,
                        dataLabels: [
                            {
                                enabled: true,
                                distance: 20,
                                format: "{point.name}",
                            },
                            {
                                enabled: true,
                                distance: -15,
                                format: "{point.percentage:.0f}%",
                                style: {
                                    fontSize: "0.9em",
                                },
                            },
                        ],
                        showInLegend: true,
                    },
                },
                series: [
                    {
                        name: "Registrations",
                        colorByPoint: true,
                        innerSize: "80%",
                        data: [
                            {
                                name: "Sans stage",
                                y: this.data?.students_not_in_intern_ship ?? 0,
                            },
                            {
                                name: "Fin stage",
                                y: this.data?.students_finished_intern_ship ?? 0,
                            },
                            {
                                name: "En stage",
                                y: this.data?.students_in_intern_ship ?? 0,
                            },
                        ],
                    },
                ],
            },
            chartOptions: {
                legend: {
                    enabled: false,
                },
                title: {
                    text: "",
                },
                xAxis: {
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                },
                tooltip: {
                    crosshairs: true,
                    shared: true,
                },
                credits: {
                    enabled: false,
                },
                plotOptions: {
                    line: {
                        color: "#259475",
                        lineWidth: 3,
                        marker: {
                            enabled: false,
                            radius: 4,
                            lineColor: "#061A53",
                            lineWidth: 0,
                        },
                    },
                },
                yAxis: {
                    lineWidth: 0,
                    title: {
                        text: "",
                    },
                },
                chart: {
                    type: "line",
                    title: "Hassaan",
                    backgroundColor: "#FFF",
                    borderWidth: 0,
                    plotBackgroundColor: "#FFFFFF",
                    plotShadow: false,
                    plotBorderWidth: 0,
                    showAxes: true,
                    margin: [20, 50, 80, 50],
                },
                series: [
                    {
                        data: [
                            0, 300, 400, 50, 20, 240, 290, 190, 100, 200, 290,
                            300,
                        ],
                    },
                ],
            },

            statisticDataList: [
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#237AE0]",
                    name: "Tous les étudiants",
                    value: this.data?.all_students ?? 0,
                },
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#F57373]",
                    name: "Étudiants en stage",
                    value: this.data?.students_in_intern_ship ?? 0,
                },
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#F89500]",
                    name: "Étudiants sans stage",
                    value: this.data?.students_not_in_intern_ship ?? 0,
                },
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#4B9F08]",
                    name: "Etudiants en fin de stage",
                    value: this.data?.students_finished_intern_ship ?? 0,
                },
                {
                    icon: "fa-light fa-university",
                    bgColorStyle: "bg-[#6733FF]",
                    name: "Les entreprises",
                    value: this.data?.all_companies ?? 0,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#237AE0]",
                    name: "Toutes les offres",
                    value: this.data?.all_offers ?? 0,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#F89500]",
                    name: "Offres en cours",
                    value: this.data?.active_offers ?? 0,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#D70027]",
                    name: "Offres expirées",
                    value: this.data?.expired_offers ?? 0,
                },
            ],
        };
    },

    methods: {
        currentLine(index) {
            this.indicator = index;
        },
    },
};
</script>

<style scoped>
.contenthistory {
    background: #ffffff;
    border-radius: 0px 0px 16px 16px;
    padding: 24px 24px 24px 16px;
}
</style>
