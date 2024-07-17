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
                            <button
                                class="relative flex items-center justify-center gap-2 h-[50px] sm:w-1/3 w-full text-[#718096] rounded-lg border border-[#718096]"
                                @click="$emit('downloadToExcel')"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="flex-shrink-0 h-5 w-5 fa-light fa-filter"
                                />
                                <span class="font-bold text-sm leading-6"
                                    >Filtrer</span
                                >
                            </button>

                            <!-- Télécharger -->
                            <ExportButton />
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
                                {{ student.last_name }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.first_name }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.study_field ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ student.email }}
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
                                <TableAction
                                    :actions="actions"
                                    :resource="student"
                                    :base-route-name="'students'"
                                />
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
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchRecordsInput from "@/Shared/Forms/SearchRecordsInput.vue";
import ExportButton from "@/Shared/Forms/ExportButton.vue";
import TableHead from "@/Shared/Tables/TableHead.vue";
import TableAction from "@/Shared/Tables/TableAction.vue";
import { defineAsyncComponent } from "vue";
import { throttle, pickBy } from "lodash";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
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
        TableAction,
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
    },

    data() {
        return {
            form: {
                search: this.filters.search,
            },

            tableHeader: [
                "Matricule",
                "Nom",
                "Prénom",
                "Filière",
                "Email",
                "Statut",
            ],
            actions: [
                "show",
                "update",
                "destroy",
            ],
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
};
</script>
