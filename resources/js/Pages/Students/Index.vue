<template>
    <div class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
        <div class="flex flex-col bg-[#FFFFFF] p-4 rounded-lg">
            <div class="flex w-full justify-start">
                <PrimaryButton
                    type="submit"
                    title="Importer un fichier excel des étudiants qui ne figurent pas encore sur la plateforme"
                    class="ml-0 flex space-x-2 sm:w-auto w-full"
                    @click="showImportItemModal = true"
                >
                    <span>Importer la liste des étudiants</span>
                    <FontAwesomeIcon size="fa-light fa-file-import" />
                </PrimaryButton>
            </div>
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
                        <label class="text-sm"> Filière </label>
                        <br />
                        <div class="flex items-center justify-start w-full">
                            <img
                                src="@/Assets/icons/flter_icon.svg"
                                alt=""
                                class="mr-3"
                            />
                            <select
                                class="outline-none rounded-md font-medium w-full bg-white"
                                v-model="form.study_field"
                            >
                                <option value="">Tous</option>
                                <option
                                    v-for="item of studyFields"
                                    :key="item.value"
                                    :value="item.value"
                                >
                                    {{ item.label }}
                                </option>
                            </select>
                        </div>
                    </div>
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
                                v-model="form.internship_status"
                            >
                                <option value="">Tous</option>
                                <option
                                    v-for="item of internshipStatus"
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
                            v-for="student in students.data"
                            :key="student.id"
                            class="bg-white even:bg-gray-50"
                        >
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.matriculation_number }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.user?.last_name }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.user?.first_name }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.study_field ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.academic_year ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.user?.email }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                <span
                                    class="flex justify-center items-center w-[110px] h-8 rounded"
                                    :class="
                                        student.internship_status === 'En stage'
                                            ? 'bg-[#4b9f0814] text-[#4B9F08]'
                                            : student.internship_status ===
                                                'Pas en stage'
                                              ? 'bg-[#f5737314] text-[#F57373]'
                                              : 'bg-[#f8950014] text-[#F89500]'
                                    "
                                >
                                    {{ student.internship_status ?? "-" }}</span
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
                                                            'students.show',
                                                            student.id,
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
                                            <!-- <li class="w-full p-2">
                                                <InertiaLink
                                                    :href="
                                                        route(
                                                            `students.edit`,
                                                            student.id,
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
                                                    @click="destroy(student)"
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
                        <tr v-if="students.data.length === 0">
                            <td
                                class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium"
                                colspan="8"
                            >
                                Aucun étudiant trouvé.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br />
            <Pagination class="justify-end" :links="students.links" />
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

        <ImportStudentForm
            v-if="showImportItemModal"
            :open-full-screen-modal="showImportItemModal"
            @update-full-screen-modal-status="onImportItemModal"
        />
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
import PrimaryButton from "@/Shared/PrimaryButton.vue";
import ImportStudentForm from "@/Shared/Forms/ImportStudentForm.vue";

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
        FilterButton,
        ConfirmationDialog,
        PrimaryButton,
        ImportStudentForm
    },

    layout: AppLayout,

    props: {
        filters: Object,
        students: {
            type: Object,
            default() {
                return {};
            },
        },

        studyFields: {
            type: Array,
            default() {
                return [];
            },
        },

        internshipStatus: {
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
                study_field: this.filters.study_field,
                internship_status: this.filters.internship_status,
            },

            showImportItemModal: false,

            tableHeader: [
                "Matricule",
                "Nom",
                "Prénom",
                "Filière",
                "Année",
                "Email",
                "Statut",
            ],
            selectedStudent: null,
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
                this.$inertia.get("/students", pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
        },
    },

    methods: {
        destroy(selectedStudent) {
            this.selectedStudent = selectedStudent;
            this.openModal(selectedStudent);
        },

        openModal(selectedStudent) {
            this.dialogBox.message = `Êtes-vous sûr de vouloir supprimer l'étudiant "${selectedStudent.last_name} ${selectedStudent.first_name}" ?`;
            this.showModal = true;
        },

        confirm() {
            this.showModal = false;
            this.$inertia.delete(`/students/${this.selectedStudent.id}`);
        },

        onImportItemModal(newStatus) {
            this.showImportItemModal = newStatus;
        },

        close() {
            this.showModal = false;
        },
    },
};
</script>
