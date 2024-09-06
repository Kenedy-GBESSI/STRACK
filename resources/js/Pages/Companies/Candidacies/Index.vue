<template>
    <div class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
        <div class="flex flex-col bg-[#FFFFFF] p-4 rounded-lg">
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
                                {{ candidacy.offer?.intern_ship?.title ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ candidacy.student?.user?.full_name ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ candidacy.student?.study_field ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ candidacy.student?.academic_year ?? "-" }}
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
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium cursor-pointer"
                            >
                                <Dropdown :overlay="false" direction="right">
                                    <template #trigger>
                                        <button>
                                            <img
                                                src="@/Assets/icons/trois_points.svg"
                                                alt=""
                                                class="anchor cursor-pointer"
                                            />
                                        </button>
                                    </template>

                                    <template #content>
                                        <ul class="divide-y divide-gray-300">
                                            <li class="w-full p-2">
                                                <InertiaLink
                                                    :href="
                                                        route(
                                                            'candidacies.show',
                                                            candidacy.id,
                                                        )
                                                    "
                                                    class="text-sm font-semibold text-[#268FF2]"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-eye"
                                                    />
                                                    <span class="pl-2"
                                                        >Voir détails</span
                                                    >
                                                </InertiaLink>
                                            </li>
                                            <li
                                                v-if="
                                                    candidacy.status !==
                                                    'Rejeté'
                                                "
                                                class="w-full p-2"
                                            >
                                                <button
                                                    title="Rejeter"
                                                    @click="
                                                        rejectComapany(
                                                            candidacy,
                                                        )
                                                    "
                                                    class="text-sm font-semibold text-[#f23a26] w-full text-left"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-eject"
                                                    />
                                                    <span class="pl-2"
                                                        >Rejecter</span
                                                    >
                                                </button>
                                            </li>
                                            <li
                                                v-if="
                                                    candidacy.status !==
                                                    'Validé'
                                                "
                                                class="w-full p-2"
                                            >
                                                <button
                                                    title="Valider"
                                                    @click="
                                                        validateCompany(
                                                            candidacy,
                                                        )
                                                    "
                                                    class="text-sm font-semibold text-[#268FF2] w-full text-left"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-check"
                                                    />
                                                    <span class="pl-2"
                                                        >Valider</span
                                                    >
                                                </button>
                                            </li>
                                        </ul>
                                    </template>
                                </Dropdown>
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
        <Teleport to="body">
            <ConfirmationDialog
                v-if="showRejectModal"
                :message="dialogRejectBox.message"
                :title="'Confirmer le reject'"
                :show="showRejectModal"
                @confirm="confirmRejectModal()"
                @close="closeRejectModal()"
            />
            <ConfirmationDialogSuccess
                v-if="showValidateModal"
                :message="dialogValidateBox.message"
                :title="'Confirmer la validation'"
                :show="showValidateModal"
                @confirm="confirmValidateModal()"
                @close="closeValidateModal()"
            />
        </Teleport>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchRecordsInput from "@/Shared/Forms/SearchRecordsInput.vue";
import FilterButton from "@/Shared/Forms/FilterButton.vue";
import TableHead from "@/Shared/Tables/TableHead.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { Link as InertiaLink } from "@inertiajs/vue3";
import { defineAsyncComponent } from "vue";
import { throttle, pickBy } from "lodash";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

const ConfirmationDialog = defineAsyncComponent({
    loader: () => import("@/Shared/ConfirmationDialog.vue"),
});

const ConfirmationDialogSuccess = defineAsyncComponent({
    loader: () => import("@/Shared/ConfirmationDialogSuccess.vue"),
});

const Pagination = defineAsyncComponent({
    loader: () => import("@/Shared/Pagination.vue"),
});

export default {
    components: {
        AppLayout,
        FontAwesomeIcon,
        SearchRecordsInput,
        TableHead,
        Pagination,
        Dropdown,
        InertiaLink,
        FilterButton,
        ConfirmationDialog,
        ConfirmationDialogSuccess,
    },

    layout: AppLayout,

    props: {
        filters: Object,
        candidacies: {
            type: Object,
            default() {
                return {};
            },
        },

        status: {
            type: Array,
            default() {
                return [];
            },
        },
    },

    data() {
        return {
            form: {
                search: this.filters.search,
                candidacy_status: this.filters.candidacy_status,
            },

            tableHeader: [
                "Offre",
                "Stage",
                "Étudiant",
                "Filière Étudiant",
                "Année Étudiant",
                "Status",
            ],

            showFilters: false,

            rejectedCandidacy: null,
            showRejectModal: false,
            dialogRejectBox: {
                message: "",
            },

            validatedCandidacy: null,
            showValidateModal: false,
            dialogValidateBox: {
                message: "",
            },
        };
    },

    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/candidacies", pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
        },
    },

    methods: {
        rejectedCandidacy(candidacy) {
            this.rejectedCandidacy = candidacy;
            this.openRejectModal(candidacy);
        },

        validatedCandidacy(company) {
            this.validatedCompany = company;
            this.openValidateModal(company);
        },

        openRejectModal(rejectedCandidacy) {
            this.dialogRejectBox.message = `Êtes-vous sûr de vouloir rejecter la candidature de l'étudiant "${rejectedCandidacy?.student?.user?.full_name}" ?`;
            this.showRejectModal = true;
        },

        openValidateModal(validatedCandidacy) {
            this.dialogValidateBox.message = `Êtes-vous sûr de vouloir valider l'entreprise "${validatedCandidacy?.student?.user?.full_name}" ?`;
            this.showValidateModal = true;
        },

        confirmRejectModal() {
            this.showRejectModal = false;
            this.$inertia.post(`/companies/${this.rejectedCandidacy.id}/reject`);
        },

        confirmValidateModal() {
            this.showValidateModal = false;
            this.$inertia.post(
                `/companies/${this.validatedCandidacy.id}/validate`,
            );
        },

        closeRejectModal() {
            this.showRejectModal = false;
        },

        closeValidateModal() {
            this.showValidateModal = false;
        },
    },
};
</script>

<style scoped></style>
