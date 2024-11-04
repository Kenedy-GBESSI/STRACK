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
        <div class="flex flex-col bg-[#FFFFFF]">
            <div class="flex flex-col p-6">
                <div class="flex flex-col space-y-4">
                    <div
                        class="flex sm:space-x-6 sm:space-y-0 space-x-1 space-y-4 px-4 flex-wrap sm:items-start items-center"
                    >
                        <InertiaLink
                            :href="route('interns')"
                            class="flex justify-center items-center w-10 h-10 rounded-full bg-[#F4F4F4]"
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="flex-shrink-0 h-5 w-5 fa-light fa-arrow-left text-[#808080]"
                            />
                        </InertiaLink>
                        <div>
                            <h1 class="font-bold text-2xl leading-8">
                                Stagiaire
                                {{ intern?.student?.user?.full_name }}
                            </h1>
                            <p class="font-medium text-[#525252] leading-6">
                                {{ intern?.student?.matriculation_number }}
                            </p>
                        </div>
                        <span
                            class="flex justify-center items-center w-[110px] h-8 font-bold text-lg border border-[#145ee080] rounded-[24px] bg-[#E8F0FF] text-[#145EE0]"
                        >
                            Note: {{ intern?.company_note ?? "-" }}
                        </span>
                    </div>

                    <ul class="flex flex-col">
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Matricule de l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ intern?.student?.matriculation_number }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Nom de l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ intern?.student?.user?.last_name }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Prénom de l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ intern?.student?.user?.first_name }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Filière de l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ intern?.student?.study_field }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Année de l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ intern?.student?.academic_year }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Début de stage :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ formatDate(intern?.start_date) }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Date de fin de stage :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ formatDate(intern?.end_date) }}
                            </p>
                        </li>
                        <li
                            v-if="intern?.fileData"
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p class="font-semibold pb-4">
                                Rapport de l'étudiant
                            </p>
                            <FileManager
                                class="w-full"
                                :attached-files="intern?.fileData ?? []"
                                label-idle="AUCUN RAPPORT"
                                :allow-multiple="false"
                                :allow-image-prewiew="true"
                                :disabled="true"
                            />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div v-if="intern.is_intern_ship_valid">
            <div class="py-4 flex justify-start items-center">
                <PrimaryButton
                    v-if="intern?.is_intern_ship_valid !== false"
                    class="inline-flex items-center py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-red-500 hover:bg-red-700 active:bg-red-900"
                    @click.prevent="openInvalidModal"
                >
                    Invalider le rapport de stage
                </PrimaryButton>

                <PrimaryButton
                    v-if="intern?.is_intern_ship_valid !== true"
                    type="submit"
                    @click.prevent="openValidModal"
                >
                    Valider le rapport de stage
                </PrimaryButton>
            </div>
        </div>
        <Teleport to="body">
            <ConfirmationDialog
                v-if="showInvalidModal"
                :message="dialogInvalidBox.message"
                :title="'Confirmer l\'invalidation'"
                :show="showInvalidModal"
                @confirm="confirmInvalidModal()"
                @close="closeInvalidModal()"
            />
            <ConfirmationDialogSuccess
                v-if="showValidModal"
                :message="dialogValidBox.message"
                :title="'Confirmer la validation'"
                :show="showValidModal"
                @confirm="confirmValidModal()"
                @close="closeValidModal()"
            />
        </Teleport>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import FileManager from "@/Shared/FileManager.vue";
import { defineAsyncComponent } from "vue";
import { Link as InertiaLink } from "@inertiajs/vue3";
import PrimaryButton from "@/Shared/PrimaryButton.vue";
import useDateUtilities from "@/Composables/dateUtilities.js";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

const ConfirmationDialog = defineAsyncComponent({
    loader: () => import("@/Shared/ConfirmationDialog.vue"),
});

const ConfirmationDialogSuccess = defineAsyncComponent({
    loader: () => import("@/Shared/ConfirmationDialogSuccess.vue"),
});

export default {
    components: {
        InertiaLink,
        FontAwesomeIcon,
        FileManager,
        PrimaryButton,
        ConfirmationDialog,
        ConfirmationDialogSuccess,
    },

    layout: AppLayout,
    props: {
        intern: Object,
    },

    setup() {
        const { formatDate } = useDateUtilities();

        return { formatDate };
    },

    data() {
        return {
            showInvalidModal: false,
            dialogInvalidBox: {
                message: "",
            },

            showValidModal: false,
            dialogValidBox: {
                message: "",
            },
        };
    },
    methods: {
        openInvalidModal() {
            this.dialogInvalidBox.message = `Êtes-vous sûr de vouloir invalider le rapport du stagiaire "${this.intern?.student?.user?.full_name}" ?`;
            this.showInvalidModal = true;
        },

        openValidModal() {
            this.dialogValidBox.message = `Êtes-vous sûr de vouloir valider le rapport du stagiaire "${this.intern?.student?.user?.full_name}" ?`;
            this.showValidModal = true;
        },

        confirmInvalidModal() {
            this.showInvalidModal = false;
            this.$inertia.post(`/intern/${this.intern.id}/reject-rapport-file`);
        },

        confirmValidModal() {
            this.showValidModal = false;
            this.$inertia.post(
                `/intern/${this.intern.id}/validate-rapport-file`,
            );
        },

        closeInvalidModal() {
            this.showInvalidModal = false;
        },

        closeValidModal() {
            this.showValidModal = false;
        },
    },
};
</script>

<style scoped></style>
