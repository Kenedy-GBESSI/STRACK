<template>
    <div
        v-if="
            $page.props.auth.user.role === 'Company' &&
            $page.props.auth.user.profile?.partnership_status !== 'Validé'
        "
        class="w-full flex my-8 justify-center items-center"
    >
        <div
            class="xl:w-[913px] w-[87%] xl:px-2 px-3 flex space-x-[8px] bg-[#F9FBFF] xl:rounded-[32px] rounded-[100px] border border-red-500 xl:h-[66px] h-[68px] xl:py-1 py-2 items-center justify-center"
        >
            <span
                v-if="
                    $page.props.auth.user.profile?.partnership_status ===
                    'Nouveau'
                "
                class="font-semibold sm:text-[24px] text-[13px] text-red-400"
                >Veuillez attendre ! Vous êtes en attente de validation...</span
            >
            <span
                v-if="
                    $page.props.auth.user.profile?.partnership_status ===
                    'Rejeté'
                "
                class="font-semibold sm:text-[24px] text-[13px] text-red-400"
                >Compte réjeté ! Votre entreprise ne répond pas aux normes
                d'IFRI</span
            >
        </div>
    </div>

    <div v-else class="m-4">
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

    props: {
        data: {
            type: Object,
            default() {
                return {};
            },
        },
    },

    layout: AppLayout,
    data() {
        return {
            indicator: 0,
            chartOptionsPie: {
                chart: {
                    type: "pie",
                    custom: {
                        totalStudents: this.data?.all_interns ?? 0,
                    },
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;
                            const totalStudents =
                                chart.options.chart.custom.totalStudents ?? 0;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer
                                        .label(
                                            `Tous les stagiaires<br/><strong>${totalStudents}</strong>`,
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
                                name: "Fin stage",
                                y: this.data?.intern_finished_intern_ship,
                            },
                            {
                                name: "En stage",
                                y:
                                    this.data?.all_interns ??
                                    0 -
                                        this.data
                                            ?.intern_finished_intern_ship ??
                                    0,
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
                    name: "Tous les stagiaires",
                    value: this.data?.all_interns ?? 0,
                },
                {
                    icon: "fa-light fa-users",
                    bgColorStyle: "bg-[#4B9F08]",
                    name: "Stagiaires en fin de stage",
                    value: this.data?.intern_finished_intern_ship ?? 0,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#237AE0]",
                    name: "Toutes mes offres",
                    value: this.data?.all_offers ?? 0,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#F89500]",
                    name: "Mes offres en cours",
                    value: this.data?.active_offers ?? 0,
                },
                {
                    icon: "fa-light fa-file-zipper",
                    bgColorStyle: "bg-[#D70027]",
                    name: "Mes offres expirées",
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
