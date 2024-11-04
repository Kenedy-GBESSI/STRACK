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

    <div v-else class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
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
                            class="relative"
                            :class="$page.props.auth.user.role === 'Institute' ? 'sm:w-10/12 w-full': 'w-full'"
                        />
                        <div
                            v-if="$page.props.auth.user.role === 'Institute'"
                            class="flex sm:flex-row flex-col sm:space-x-4 sm:space-y-0 space-x-0 space-y-4 sm:w-2/12 w-full"
                        >
                            <InertiaLink
                                class="inline-flex items-center justify-center w-full py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#007AED] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :href="route('intern-ships.create')"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="flex-shrink-0 h-4 w-4 fa-light fa-plus"
                                />

                                <span class="pl-3">Nouveau</span>
                            </InertiaLink>
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
                            v-for="internShip in internShips.data"
                            :key="internShip.id"
                            class="bg-white even:bg-gray-50"
                        >
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ internShip.title }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ internShip.academic_year ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{
                                    truncateText(internShip.description) ?? "-"
                                }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ formatDate(internShip.start_date) ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ formatDate(internShip.end_date) ?? "-" }}
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
                                                            'intern-ships.show',
                                                            internShip.id,
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
                                                    $page.props.auth.user
                                                        .role === 'Institute'
                                                "
                                                class="w-full p-2"
                                            >
                                                <InertiaLink
                                                    :href="
                                                        route(
                                                            `intern-ships.edit`,
                                                            internShip.id,
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
                                            </li>
                                            <li
                                                v-if="
                                                    $page.props.auth.user
                                                        .role === 'Company'
                                                "
                                                class="w-full p-2"
                                            >
                                                <InertiaLink
                                                    :title="'Créer de nouvelle offre à base de ce stage'"
                                                    :href="
                                                        '/offers/create?from_intern_ship_id=' +
                                                        internShip.id
                                                    "
                                                    class="text-sm font-semibold text-[#268FF2]"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-plus"
                                                    />
                                                    <span class="pl-2"
                                                        >Nouvelle offre</span
                                                    >
                                                </InertiaLink>
                                            </li>
                                            <li
                                                v-if="
                                                    $page.props.auth.user
                                                        .role === 'Institute'
                                                "
                                                class="w-full p-2"
                                            >
                                                <button
                                                    title="Supprimer"
                                                    @click="destroy(internShip)"
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
                        <tr v-if="internShips.data.length === 0">
                            <td
                                class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium"
                                colspan="8"
                            >
                                Aucun stage trouvé.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br />
            <Pagination class="justify-end" :links="internShips.links" />
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
        </Teleport>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchRecordsInput from "@/Shared/Forms/SearchRecordsInput.vue";
import ExportButton from "@/Shared/Forms/ExportButton.vue";
import useDateUtilities from "@/Composables/dateUtilities.js";
import useStringUtilities from "@/Composables/stringUtilities.js";
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
        ConfirmationDialog,
        ExportButton,
    },

    layout: AppLayout,

    props: {
        filters: Object,
        internShips: {
            type: Object,
            default() {
                return {};
            },
        },
    },

    setup() {
        const { formatDate } = useDateUtilities();
        const { isEmptyString, truncateText } = useStringUtilities();

        return { formatDate, isEmptyString, truncateText };
    },

    data() {
        return {
            form: {
                search: this.filters.search,
            },

            tableHeader: [
                "Titre",
                "Année",
                "Description",
                "Date de démarage",
                "Date de fin",
            ],
            selectedInternShip: null,
            showFilters: false,
            showModal: false,
            dialogBox: {
                message: "",
            },
        };
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/intern-ships", pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
        },
    },

    methods: {
        destroy(selectedInternShip) {
            this.selectedInternShip = selectedInternShip;
            this.openModal(selectedInternShip);
        },

        openModal(selectedInternShip) {
            this.dialogBox.message = `Êtes-vous sûr de vouloir supprimer le stage "${selectedInternShip.title}" ?`;
            this.showModal = true;
        },

        confirm() {
            this.showModal = false;
            this.$inertia.delete(`/intern-ships/${this.selectedInternShip.id}`);
        },

        close() {
            this.showModal = false;
        },
    },
};
</script>
