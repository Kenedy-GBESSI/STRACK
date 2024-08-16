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
                                class="h-[50px] sm:w-1/3 w-full"
                                @click="showFilters = !showFilters"
                            />

                            <!-- Télécharger -->
                            <ExportButton />
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
                        <label class="text-sm"> Status de stage </label>
                        <br />
                        <div class="flex items-center justify-start w-full">
                            <img
                                src="@/Assets/icons/flter_icon.svg"
                                alt=""
                                class="mr-3"
                            />
                            <select
                                class="outline-none rounded-md font-medium w-full bg-white"
                                v-model="form.partnership_status"
                            >
                                <option value="">Tous</option>
                                <option
                                    v-for="item of partnerShipStatus"
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
                            v-for="company in companies.data"
                            :key="company.id"
                            class="bg-white even:bg-gray-50"
                        >
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ company.company_name ?? '-' }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ company.user?.full_name}}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ company.address ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ company.phone_number ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ company.user?.email }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                <span
                                    class="flex justify-center items-center w-[110px] h-8 rounded"
                                    :class="
                                        company.partnership_status === 'Validé'
                                            ? 'bg-[#4b9f0814] text-[#4B9F08]'
                                            : company.partnership_status ===
                                                'Rejeté'
                                              ? 'bg-[#f5737314] text-[#F57373]'
                                              : 'bg-[#f8950014] text-[#F89500]'
                                    "
                                >
                                    {{ company.partnership_status ?? "-" }}</span
                                >
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
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
                                                            'companies.show',
                                                            company.id,
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
                                                v-if="company.partnership_status !== 'Rejeté'"
                                                class="w-full p-2">
                                                <button
                                                    title="Rejeter"
                                                    @click="rejectComapany(company)"
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
                                                v-if="company.partnership_status !== 'Validé'"
                                                class="w-full p-2">
                                                <button
                                                    title="Valider"
                                                    @click="validateCompany(company)"
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
                                            <!-- <li class="w-full p-2">
                                                <InertiaLink
                                                    :href="
                                                        route(
                                                            `companies.edit`,
                                                            company.id,
                                                        )
                                                    "
                                                    class="text-sm font-semibold text-[#268FF2]"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-pencil"
                                                    />
                                                    <span class="pl-2"
                                                        >Mettre à jour</span
                                                    >
                                                </InertiaLink>
                                            </li> -->
                                            <li class="w-full p-2">
                                                <button
                                                    title="Supprimer"
                                                    @click="destroy(company)"
                                                    class="text-sm font-semibold text-[#f23a26] w-full text-left"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-trash-can"
                                                    />
                                                    <span class="pl-2"
                                                        >Supprimer</span
                                                    >
                                                </button>
                                            </li>
                                        </ul>
                                    </template>
                                </Dropdown>
                            </td>
                        </tr>
                        <tr v-if="companies.data.length === 0">
                            <td
                                class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium"
                                colspan="8"
                            >
                                Aucune entreprise trouvée.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br />
            <Pagination class="justify-end" :links="companies.links" />
        </div>
        <Teleport to="body">
            <ConfirmationDialog
                v-if="showModal"
                :message="dialogBox.message"
                :title="'Confirmer la suppression'"
                :show="showModal"
                @confirm="confirm()"
                @close="close()"
            />
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
import ExportButton from "@/Shared/Forms/ExportButton.vue";
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
        ExportButton,
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
        companies: {
            type: Object,
            default() {
                return {};
            },
        },

        partnerShipStatus: {
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
                partnership_status: this.filters.partnership_status,
            },

            tableHeader: [
                "Nom de l'entreprise",
                "Promoteur",
                "Adresse",
                "Téléphone",
                "Email",
                "Statut",
            ],
            selectedCompany: null,
            showFilters: false,
            showModal: false,
            dialogBox: {
                message: "",
            },

            rejectedCompany: null,
            showRejectModal: false,
            dialogRejectBox: {
                message: "",
            },

            validatedCompany: null,
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
                this.$inertia.get("/companies", pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
        },
    },

    methods: {
        destroy(selectedCompany) {
            this.selectedCompany = selectedCompany;
            this.openModal(selectedCompany);
        },

        rejectComapany(company){
            this.rejectedCompany = company;
            this.openRejectModal(company);
        },

        validateCompany(company) {
            this.validatedCompany = company;
            this.openValidateModal(company);
        },

        openModal(selectedCompany) {
            this.dialogBox.message = `Êtes-vous sûr de vouloir supprimer l'entreprise "${selectedCompany?.company_name}" ?`;
            this.showModal = true;
        },

        openRejectModal(rejectedCompany) {
            this.dialogRejectBox.message = `Êtes-vous sûr de vouloir rejecter l'entreprise "${rejectedCompany?.company_name}" ?`;
            this.showRejectModal = true;
        },

        openValidateModal(validatedCompany) {
            this.dialogValidateBox.message = `Êtes-vous sûr de vouloir valider l'entreprise "${validatedCompany?.company_name}" ?`;
            this.showValidateModal = true;
        },

        confirm() {
            this.showModal = false;
            this.$inertia.delete(`/companies/${this.selectedCompany.id}`);
        },

        confirmRejectModal() {
            this.showRejectModal = false;
            this.$inertia.post(`/companies/${this.rejectedCompany.id}/reject`);
        },

        confirmValidateModal() {
            this.showValidateModal = false;
            this.$inertia.post(`/companies/${this.validatedCompany.id}/validate`);
        },

        close() {
            this.showModal = false;
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
