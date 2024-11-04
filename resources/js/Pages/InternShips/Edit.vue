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
                        class="flex sm:space-x-6 sm:space-y-0 px-4 flex-wrap sm:items-start items-center"
                    >
                        <InertiaLink
                            :href="route('intern-ships.index')"
                            class="flex justify-center items-center w-10 h-10 rounded-full bg-[#F4F4F4]"
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="flex-shrink-0 h-5 w-5 fa-light fa-arrow-left text-[#808080]"
                            />
                        </InertiaLink>
                        <div class="sm:pl-0 pl-1">
                            <h1
                                class="font-bold sm:text-2xl text-base leading-8"
                            >
                                Mettre à jour la compagne de stage <i>{{ internShip?.title }}</i>
                            </h1>
                        </div>
                    </div>
                    <div class="bg-white max-w-full">
                        <form @submit.prevent="submit">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="flex flex-wrap -mr-6">
                                    <div class="pr-6 pb-4 lg:w-1/4 w-full">
                                        <InputLabel
                                            for="title"
                                            value="Titre *"
                                        />
                                        <TextInput
                                            id="title"
                                            v-model="form.title"
                                            name="title"
                                            type="text"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.title"
                                        />
                                    </div>
                                    <DatePicker
                                        v-model="form.start_date"
                                        :required="true"
                                        aria-required="true"
                                        name="start_date"
                                        label="Date de démarage *"
                                        :error="form.errors.start_date"
                                        class="pb-4 pr-6 w-full lg:w-1/4"
                                    />
                                    <DatePicker
                                        v-model="form.end_date"
                                        :required="true"
                                        aria-required="true"
                                        name="end_date"
                                        label="Date de fin *"
                                        :error="form.errors.end_date"
                                        class="pb-4 pr-6 w-full lg:w-1/4"
                                    />
                                    <div class="pr-6 pb-4 lg:w-1/4 w-full">
                                        <InputLabel
                                            for="academic_year"
                                            value="Année"
                                        />
                                        <Multiselect
                                            id="academic_year"
                                            v-model="form.academic_year"
                                            autocomplete="off"
                                            :searchable="true"
                                            :options="academicYears"
                                            name="academic_year"
                                            placeholder="Chercher une année"
                                        >
                                            <template #noresults>
                                                <div
                                                    class="multiselect-no-results"
                                                >
                                                    Oops! Aucun élément trouvé.
                                                </div>
                                            </template>
                                        </Multiselect>
                                        <InputError
                                            class="mt-2"
                                            :message="
                                                form.errors.academic_year
                                            "
                                        />
                                    </div>
                                    <div class="pb-4 pr-6 w-full flex flex-col">
                                        <InputLabel
                                            for="description"
                                            value="Description"
                                        />
                                        <Textarea
                                            id="description"
                                            v-model="form.description"
                                            name="description"
                                            placeholder="Ex: Nous sommes ..."
                                        >
                                        </Textarea>
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.description"
                                        />
                                    </div>
                                </div>
                                <div class="w-full">
                                    <p class="font-bold">Fichier associé</p>
                                    <FileManager
                                        class="w-full"
                                        :attached-files="form.fileData"
                                        label-idle="Ajouter un(e) image/fichier"
                                        :allow-multiple="false"
                                        :allow-image-prewiew="true"
                                        @update-files="onUpdatePhoto"
                                    />
                                </div>
                            </div>
                            <div
                                class="px-4 sm:px-6 py-4 flex justify-end items-center"
                            >
                                <InertiaLink
                                    :href="route('intern-ships.index')"
                                    class="inline-flex items-center py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-red-500 hover:bg-red-700 active:bg-red-900"
                                    :disabled="form.processing"
                                >
                                    Retour
                                </InertiaLink>

                                <PrimaryButton
                                    :loading="form.processing"
                                    :disabled="
                                        checkIfSubmitButtonShouldBeDisabled
                                    "
                                    type="submit"
                                >
                                    Enregistrer
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link as InertiaLink } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { defineAsyncComponent } from "vue";
import Textarea from "@/Components/Textarea.vue";
import DatePicker from "@/Shared/DatePicker.vue";
import FileManager from "@/Shared/FileManager.vue";
import PrimaryButton from "@/Shared/PrimaryButton.vue";
import useStringUtilities from "@/Composables/stringUtilities.js";
import Multiselect from "@vueform/multiselect";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

export default {
    components: {
        InertiaLink,
        FontAwesomeIcon,
        InputError,
        InputLabel,
        TextInput,
        DatePicker,
        Textarea,
        FileManager,
        PrimaryButton,
        Multiselect,
    },

    layout: AppLayout,

    props: {
        internShip: {
            type: Object,
            required: true,
        },

        academicYears: {
            type: Array,
            default() {
                return []
            }
        }
    },

    setup() {
        const { isEmptyString } = useStringUtilities();

        return { isEmptyString };
    },

    data() {
        return {
            form: this.$inertia.form({
                start_date: this.internShip?.start_date ?? null,
                end_date: this.internShip?.end_date ?? null,
                title: this.internShip?.title ?? null,
                description: this.internShip?.description ?? null,
                academic_year: this.internShip?.academic_year ?? null,
                fileData: this.internShip?.fileData ?? [],
            }),
        };
    },

    computed: {
        checkIfSubmitButtonShouldBeDisabled() {
            return (
                this.form.processing ||
                this.isEmptyString(this.form.title) ||
                this.isEmptyString(this.form.start_date) ||
                this.isEmptyString(this.form.end_date) ||
                this.isEmptyString(this.form.academic_year)
            );
        },
    },

    methods: {
        onUpdatePhoto(newFile) {
            this.form.fileData = newFile;
        },

        submit() {
            this.form.put(`/intern-ships/${this.internShip.id}`, {
                preserveScroll: true,
                onBefore: () => {
                    if (this.form.hasErrors) {
                        this.form.clearErrors();
                    }
                    if (this.checkIfSubmitButtonShouldBeDisabled) {
                        return false;
                    }
                },
            });
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
