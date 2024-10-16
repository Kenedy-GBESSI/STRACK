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
                            :href="route('candidacies')"
                            class="flex justify-center items-center w-10 h-10 rounded-full bg-[#F4F4F4]"
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="flex-shrink-0 h-5 w-5 fa-light fa-arrow-left text-[#808080]"
                            />
                        </InertiaLink>
                        <div>
                            <h1 class="font-bold text-2xl leading-8">
                                Candidature de
                                {{ candidacy?.student?.user?.full_name }}
                            </h1>
                            <p class="font-medium text-[#525252] leading-6">
                                {{ candidacy?.student?.matriculation_number }}
                            </p>
                        </div>
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
                        <span
                            v-if="candidacy.status !== 'Validé'"
                            title="Valider la candidature"
                            class="flex justify-center items-center w-[130px] h-8 rounded bg-[#4b9f0814] text-[#4B9F08] cursor-pointer"
                        >
                            Je veux valider
                        </span>

                        <span
                            v-if="candidacy.status !== 'Rejeté'"
                            title="Rejeter la candidature"
                            class="flex justify-center items-center w-[130px] h-8 rounded bg-[#f5737314] text-[#F57373] cursor-pointer"
                        >
                            Je veux rejeter
                        </span>
                    </div>

                    <ul class="flex flex-col">
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Offre postulée par l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ candidacy?.offer?.title }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Le stage lié à l'offre :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ candidacy?.offer?.intern_ship?.title ?? "-" }}
                            </p>
                        </li>
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
                                {{ candidacy?.student?.matriculation_number }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Nom de l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ candidacy?.student?.user?.last_name }}
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
                                {{ candidacy?.student?.user?.first_name }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Filière de l'étudiant :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ candidacy?.student?.study_field }}
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
                                {{ candidacy?.student?.academic_year }}
                            </p>
                        </li>
                        <li
                            v-if="candidacy?.fileData"
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                        <p class="font-semibold pb-4"> CV DE L'ÉTUDIANT</p>
                            <FileManager
                                class="w-full"
                                :attached-files="candidacy?.fileData ?? []"
                                label-idle="AUCUN CV"
                                :allow-multiple="false"
                                :allow-image-prewiew="true"
                                :disabled="true"
                            />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link as InertiaLink } from "@inertiajs/vue3";
import FileManager from "@/Shared/FileManager.vue";
import { defineAsyncComponent } from "vue";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

export default {
    components: {
        InertiaLink,
        FontAwesomeIcon,
        FileManager,
    },

    layout: AppLayout,
    props: {
        candidacy: Object,
    },

    data() {
        return {
            warningDelete: false,
            deleteString: "",
        };
    },
    methods: {},
};
</script>

<style scoped>
</style>
