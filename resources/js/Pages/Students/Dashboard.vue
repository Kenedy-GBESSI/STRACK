<template>
    <div class="max-w-screen-xl mx-auto sm:py-8 py-4 px-2 mb-8">
        <section class="just-about-us w-full mb-8">
            <div
                class="max-w-screen-xl mx-auto text-white space-y-[30px] pt-4 py-0 pb-0 md:pt-4 md:py-0 md:pb-0 flex flex-col items-center"
                data-aos="fade-up"
                data-aos-duration="3000"
            >
                <p
                    class="text-center text-[#212121] text-base font-bold uppercase"
                >
                    Vous êtes en stage dans l'entreprise <i>"{{ studentInternShip?.company?.company_name}}"</i>
                </p>

                <img
                    src="@/Assets/images/study-group-african-people.jpg"
                    class="md:w-auto md:h-[666px] w-[265px] h-[180px]"
                    alt=""
                />
                <div
                    class="w-full theLast text-white flex flex-col space-y-[13px] mx-auto xl:pl-[11.5%] xl:pr-[24px] pl-[13px] pr-[13px] md:justify-start justify-center md:items-start items-center py-[32px]"
                >
                    <p
                        class="font-semibold text-[#212121] text-[24px] md:text-[40px] uppercase p-0"
                    >
                        DÉTAILS
                    </p>

                    <p
                        class="text-black w-full leading-[24px] text-sm md:text-base md:text-start text-center"
                    >DATE DE DEMARRAGE: {{ formatDate(studentInternShip?.start_date) }}</p>

                    <p
                        class="text-black w-full leading-[24px] text-sm md:text-base md:text-start text-center"
                    >DATE DE FIN: {{ formatDate(studentInternShip?.end_date) }}</p>

                    <button
                        type="button"
                        title="Envoyer un rapport"
                        class="w-[150px] text-sm bg-blue-700 rounded md:bg-transparent text-[#EDEDEF] md:p-0 btn-link font-normal"
                        aria-current="page"
                    >
                        Envoyer un rapport
                    </button>
                </div>
            </div>
        </section>

        <div class="flex flex-col bg-[#FFFFFF] p-4 rounded-lg">
            <h1 class="font-semibold pb-4 uppercase">
                Liste des différentes offres auxquelles vous avez postulées
            </h1>
            <div class="py-2 align-middle inline-block w-full">
                <div
                    class="mb-4 flex flex-row content items-center justify-between"
                >
                    <div
                        class="flex sm:flex-row flex-col sm:space-x-4 sm:space-y-0 space-x-0 space-y-4 w-full"
                    >
                        <SearchRecordsInput
                            v-model="form.search"
                            class="relative sm:w-10/12 w-full"
                        />
                        <div
                            class="flex sm:flex-row flex-col sm:space-x-4 sm:space-y-0 space-x-0 space-y-4 sm:w-2/12 w-full"
                        >
                            <!-- Filtrer -->
                            <FilterButton
                                class="h-[50px] w-full"
                                @click="showFilters = !showFilters"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-show="showFilters"
                class="mb-4 content p-4 border border-[#DADEE3] rounded bg-[#FFFFFF]"
            >
                <h6 class="font-medium sm:text-sm text-xs mb-3">Filtres</h6>
                <div class="grid sm:grid-cols-4 gap-4">
                    <div
                        class="relative gap-2 px-3 py-1 w-auto border border-[#DADEE3] rounded-md bg-white"
                    >
                        <label class="text-sm"> Status </label>
                        <br />
                        <div class="flex items-center justify-start w-full">
                            <img
                                src="@/Assets/icons/flter_icon.svg"
                                alt=""
                                class="mr-3"
                            />
                            <select
                                class="outline-none rounded-md font-medium w-full bg-white"
                                v-model="form.candidacy_status"
                            >
                                <option value="">Tous</option>
                                <option
                                    v-for="item of status"
                                    :key="item.value"
                                    :value="item.value"
                                >
                                    {{ item.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto max-h-[60vh] no-scrollbar">
                <table class="min-w-full table-fixed divide-y divide-gray-300">
                    <TableHead
                        :header="tableHeader"
                        class="sticky top-0 bg-[#FFFFFF] z-40"
                    />
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="candidacy in candidacies.data"
                            :key="candidacy.id"
                            class="bg-white even:bg-gray-50"
                        >
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ candidacy.offer?.title ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{
                                    candidacy.offer?.company?.company_name ??
                                    "-"
                                }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{
                                    candidacy.offer?.company?.phone_number ??
                                    "-"
                                }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ candidacy.offer?.company?.address ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                <span
                                    class="flex justify-center items-center w-[110px] h-8 rounded"
                                    :class="
                                        candidacy.status === 'Validé'
                                            ? 'bg-[#4b9f0814] text-[#4B9F08]'
                                            : candidacy.status === 'Rejeté'
                                              ? 'bg-[#f5737314] text-[#F57373]'
                                              : 'bg-[#f8950014] text-[#F89500]'
                                    "
                                >
                                    {{
                                        candidacy?.status === "Nouveau"
                                            ? "En cours ..."
                                            : candidacy.status ?? "-"
                                    }}</span
                                >
                            </td>
                            <td
                                class="pr-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                <InertiaLink
                                    v-if="
                                        candidacy.status === 'Validé' &&
                                        $page.props.auth.user?.profile
                                            ?.internship_status !== 'En stage'
                                    "
                                    title="Si vous appuyez , vous démarrez automatiquement votre stage dans cette entreprise."
                                    :href="`/start-intern-ship/${$page.props.auth.user?.profile?.id}/${candidacy.offer?.id}`"
                                    class="text-sm text-[#268FF2]"
                                >
                                    <span class="pl-2">Démarrer stage</span>
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr v-if="candidacies.data.length === 0">
                            <td
                                class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium"
                                colspan="8"
                            >
                                Aucune offre postulée.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br />
            <Pagination class="justify-end" :links="candidacies.links" />
        </div>
    </div>
</template>

<script>
import StudentLayout from "@/Layouts/StudentLayout.vue";
import SearchRecordsInput from "@/Shared/Forms/SearchRecordsInput.vue";
import FilterButton from "@/Shared/Forms/FilterButton.vue";
import TableHead from "@/Shared/Tables/TableHead.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { Link as InertiaLink } from "@inertiajs/vue3";
import { defineAsyncComponent } from "vue";
import { throttle, pickBy } from "lodash";
import useDateUtilities from "@/Composables/dateUtilities.js";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

const ConfirmationDialog = defineAsyncComponent({
    loader: () => import("@/Shared/ConfirmationDialog.vue"),
});

const Pagination = defineAsyncComponent({
    loader: () => import("@/Shared/Pagination.vue"),
});

export default {
    components: {
        StudentLayout,
        FontAwesomeIcon,
        SearchRecordsInput,
        TableHead,
        Pagination,
        Dropdown,
        InertiaLink,
        FilterButton,
        ConfirmationDialog,
    },

    layout: StudentLayout,

    props: {
        filters: Object,
        candidacies: {
            type: Object,
            default() {
                return {};
            },
        },

        studentInternShip: {
            type: Object,
            default() {
                return {}
            }
        },

        status: {
            type: Array,
            default() {
                return [];
            },
        },
    },

    setup() {
        const { formatDate } = useDateUtilities();

        return { formatDate };
    },

    data() {
        return {
            form: {
                search: this.filters.search,
                candidacy_status: this.filters.candidacy_status,
            },

            tableHeader: [
                "Offre",
                "Entreprise",
                "Numéro de  l'entreprise",
                "Addresse de l'entreprise",
                "Status",
            ],

            showFilters: false,
        };
    },

    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/dashboard/students", pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
        },
    },

    methods: {},
};
</script>

<style scoped>
.just-about-us > div {
    background: #f1f0ef;
    border-radius: 16px 16px 0px 0px;
}
.theLast {
    background: white;
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.btn-link {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    padding: 12px 12px;
    height: 40px;
    background: #007aed;
    border-radius: 50px;
}
@media screen and (max-width: 320px) {
    img {
        max-width: 100%;
        height: auto;
    }
}
</style>
