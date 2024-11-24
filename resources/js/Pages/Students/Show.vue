<template>
    <div class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
        <div class="flex flex-col bg-[#FFFFFF]">
            <div class="flex flex-col p-6">
                <div class="flex flex-col space-y-4">
                    <div
                        class="flex sm:space-x-6 sm:space-y-0 space-x-1 space-y-4 px-4 flex-wrap sm:items-start items-center"
                    >
                        <InertiaLink
                            :href="route('students.index')"
                            class="flex justify-center items-center w-10 h-10 rounded-full bg-[#F4F4F4]"
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="flex-shrink-0 h-5 w-5 fa-light fa-arrow-left text-[#808080]"
                            />
                        </InertiaLink>
                        <div>
                            <h1 class="font-bold text-2xl leading-8">
                                {{ student?.user?.last_name }}
                                {{ student?.user?.first_name }}
                            </h1>
                            <p class="font-medium text-[#525252] leading-6">
                                {{ student?.matriculation_number }}
                            </p>
                        </div>
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
                        <span
                            v-if="student.internShip?.data?.company_note"
                            class="flex justify-center items-center w-auto px-2 h-8 font-bold text-lg border border-[#145ee080] rounded-[24px] bg-[#E8F0FF] text-[#145EE0]"
                        >
                            Note de l'entreprise:
                            {{ student.internShip?.data?.company_note }}
                        </span>
                        <span
                            class="flex justify-center items-center w-auto px-2 h-8 font-bold text-lg border border-[#145ee080] rounded-[24px] bg-[#E8F0FF] text-[#145EE0]"
                        >
                            Note de stage:
                            {{ student.internShip?.data?.final_note ?? "-" }}
                        </span>
                    </div>

                    <ul class="flex flex-col">
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Matricule
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.matriculation_number }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Nom
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.user?.last_name }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Prénom
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.user?.first_name }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Filière
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.study_field }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Date de naissance
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                12-05-2002
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Email
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E] overflow-hidden text-ellipsis whitespace-nowrap"
                            >
                                {{ student?.user?.email }}
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div
            v-if="student.internship_status === 'En stage'"
            class="flex flex-col my-4 bg-[#FFFFFF] p-6"
        >
            <h1 class="font-bold text-2xl leading-8">Stage</h1>
            <ul class="flex flex-col">
                <li
                    class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                >
                    <p class="font-bold text-base leading-6 sm:w-1/4 w-1/2">
                        Entreprise
                    </p>
                    <p
                        class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                    >
                        {{
                            student.internShip?.data?.company?.company_name ??
                            "-"
                        }}
                    </p>
                    <p class="font-bold text-base leading-6 sm:w-1/4 w-1/2">
                        Téléphone de l'entreprise
                    </p>
                    <p
                        class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                    >
                        {{
                            student.internShip?.data?.company?.phone_number ??
                            "-"
                        }}
                    </p>
                </li>
                <li
                    class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                >
                    <p class="font-bold text-base leading-6 sm:w-1/4 w-1/2">
                        Date de début
                    </p>
                    <p
                        class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                    >
                        {{
                            formatDate(student.internShip?.data?.start_date) ??
                            "-"
                        }}
                    </p>
                    <p class="font-bold text-base leading-6 sm:w-1/4 w-1/2">
                        Date de fin
                    </p>
                    <p
                        class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                    >
                        {{
                            formatDate(student.internShip?.data?.end_date) ??
                            "-"
                        }}
                    </p>
                </li>
                <li
                    v-if="
                        student.internShip?.fileData &&
                        student.internShip?.data?.is_intern_ship_valid === true
                    "
                    class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                >
                    <p class="font-bold">RAPPORT DE STAGE</p>
                    <FileManager
                        class="w-full"
                        :attached-files="student.internShip?.fileData ?? []"
                        label-idle="AUCUN FICHIER"
                        :allow-multiple="false"
                        :allow-image-prewiew="true"
                        :disabled="true"
                    />
                </li>
            </ul>
        </div>
        <div
            v-if="
                student.internship_status === 'Pas en stage' &&
                candidacies.length > 0
            "
            class="flex flex-col my-4 bg-[#FFFFFF] p-6"
        >
            <h1 class="font-bold text-2xl leading-8">
                Le(s) offre(s) postulée(s) par l'étudiant
            </h1>
            <div class="overflow-x-auto max-h-[60vh] no-scrollbar">
                <table class="min-w-full table-fixed divide-y divide-gray-300">
                    <TableHead
                        :header="tableHeader"
                        :has-actions="false"
                        class="sticky top-0 bg-[#FFFFFF] z-40"
                    />
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="candidacy in candidacies"
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
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="student.internship_status !== 'Pas en stage'">
            <div class="my-4 flex justify-start items-center">
                <PrimaryButton type="submit" @click.prevent="openAddNoteModal">
                    Donner une note finale
                </PrimaryButton>
            </div>
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
import { Link as InertiaLink } from "@inertiajs/vue3";
import FileManager from "@/Shared/FileManager.vue";
import PrimaryButton from "@/Shared/PrimaryButton.vue";
import { defineAsyncComponent } from "vue";
import AddNoteForm from "@/Shared/Forms/AddNoteForm.vue";
import useDateUtilities from "@/Composables/dateUtilities.js";
import TableHead from "@/Shared/Tables/TableHead.vue";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

export default {
    components: {
        InertiaLink,
        FontAwesomeIcon,
        FileManager,
        PrimaryButton,
        AddNoteForm,
        TableHead,
    },

    layout: AppLayout,
    props: {
        student: Object,
        candidacies: {
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
            showNoteModal: false,

            tableHeader: [
                "Offre",
                "Entreprise",
                "Numéro de  l'entreprise",
                "Addresse de l'entreprise",
                "Status",
            ],
        };
    },
    methods: {
        confirmAddNoteModal(note) {
            this.closeAddNoteModal();
            this.$inertia.post(
                `/final-note-for-student/${this.student.internShip?.data?.id}`,
                {
                    note: note,
                },
            );
        },

        openAddNoteModal() {
            this.showNoteModal = true;
        },

        closeAddNoteModal() {
            this.showNoteModal = false;
        },
    },
};
</script>

<style scoped>
.title {
    padding: 0px 0px 16px;
    border-bottom: 1px solid #dadee3;
}
</style>
