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
            <div class="overflow-x-auto max-h-[60vh] no-scrollbar">
                <table class="min-w-full table-fixed divide-y divide-gray-300">
                    <TableHead
                        :header="tableHeader"
                        class="sticky top-0 bg-[#FFFFFF] z-40"
                    />
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="intern in interns.data"
                            :key="intern.id"
                            class="bg-white even:bg-gray-50"
                        >
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ intern.student?.user?.full_name ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ intern.student?.study_field ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ intern.student?.academic_year ?? "-" }}
                            </td>

                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ intern.intern_ship?.title ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ intern.company_note ?? "-" }}
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
                                                            'interns.show',
                                                            intern.id,
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

                                                class="w-full p-2"
                                            >
                                                <button
                                                    title="Noter le stagiaire"
                                                    class="text-sm font-semibold text-[#268FF2] w-full text-left"
                                                    @click.prevent="openAddNoteModal(intern)"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-pencil"
                                                    />
                                                    <span class="pl-2"
                                                        >Noter le stagiaire</span
                                                    >
                                                </button>
                                            </li>
                                        </ul>
                                    </template>
                                </Dropdown>
                            </td>
                        </tr>
                        <tr v-if="interns.data.length === 0">
                            <td
                                class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium"
                                colspan="8"
                            >
                                Aucun stagiaire !.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br />
            <Pagination class="justify-end" :links="interns.links" />
        </div>
        <Teleport to="body">
            <AddNoteForm
               v-if="showNoteModal"
               :show="showNoteModal"
               @close="closeAddNoteModal()"
               @confirm="confirmAddNoteModal"
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
import AddNoteForm from "@/Shared/Forms/AddNoteForm.vue";
import { defineAsyncComponent } from "vue";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
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
        AddNoteForm,
        ConfirmationDialogSuccess,
    },

    layout: AppLayout,

    props: {
        interns: {
            type: Object,
            default() {
                return {};
            },
        },
    },

    data() {
        return {
            tableHeader: [
                "Étudiant",
                "Filière Étudiant",
                "Année Étudiant",
                "Stage",
                "Note attribuée"
            ],

            showNoteModal: false,
            selectedIntern: null,
        };
    },

    watch: {

    },

    methods: {
        confirmAddNoteModal(note){
            this.closeAddNoteModal();
            this.$inertia.post(`/company-note-for-intern/${this.selectedIntern?.id}`, {
                note: note
            });
        },

        openAddNoteModal(intern) {
            this.selectedIntern = intern;
            this.showNoteModal = true;
        },

        closeAddNoteModal(){
            this.showNoteModal = false;

        }
    },
};
</script>

<style scoped></style>
