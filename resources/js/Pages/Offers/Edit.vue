<template>
    <div class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
        <div class="flex flex-col bg-[#FFFFFF]">
            <div class="flex flex-col p-6">
                <div class="flex flex-col space-y-4">
                    <div
                        class="flex sm:space-x-6 sm:space-y-0 px-4 flex-wrap sm:items-start items-center"
                    >
                        <InertiaLink
                            :href="route('offers.index')"
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
                                Création de nouvelle offre
                            </h1>
                        </div>
                    </div>

                    <div class="bg-white max-w-full sm:mx-4">
                        <div class="sm:hidden px-4 bg-white">
                            <label for="tabs" class="sr-only"
                                >Select a tab</label
                            >
                            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                            <select
                                id="tabs"
                                name="tabs"
                                class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                @change="selectTheRightTab($event)"
                            >
                                <option
                                    :selected="selectedTab === 'sheet'"
                                    value="sheet"
                                >
                                    Fiche
                                </option>

                                <option
                                    :selected="selectedTab === 'details'"
                                    value="details"
                                >
                                    Details
                                </option>

                                <option
                                    :selected="selectedTab === 'file'"
                                    value="file"
                                >
                                    Fichier associé
                                </option>
                            </select>
                        </div>
                        <div
                            class="hidden sm:block bg-white p-2 rounded border"
                        >
                            <nav
                                class="flex flex-wrap space-x-4"
                                aria-label="Tabs"
                            >
                                <a
                                    href="#"
                                    :class="
                                        selectedTab == 'sheet'
                                            ? 'bg-indigo-50 text-[#268FF2] px-3 py-2 font-medium text-sm rounded-md'
                                            : 'text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md'
                                    "
                                    @click="selectedTab = 'sheet'"
                                >
                                    Fiche
                                </a>
                                <a
                                    href="#"
                                    :class="
                                        selectedTab == 'details'
                                            ? 'bg-indigo-50 text-[#268FF2] px-3 py-2 font-medium text-sm rounded-md'
                                            : 'text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md'
                                    "
                                    @click="selectedTab = 'details'"
                                >
                                    Details
                                </a>

                                <a
                                    href="#"
                                    :class="
                                        selectedTab === 'file'
                                            ? 'bg-indigo-50 text-[#268FF2] px-3 py-2 font-medium text-sm rounded-md'
                                            : 'text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md'
                                    "
                                    @click="selectedTab = 'file'"
                                >
                                    Fichier associé
                                </a>
                            </nav>
                        </div>
                    </div>

                    <div class="bg-white max-w-full">
                        <form @submit.prevent="submit">
                            <div class="sm:pb-6 sm:pt-0 px-4 bg-white">
                                <div
                                    class="flex flex-wrap -mr-6"
                                    v-show="selectedTab === 'sheet'"
                                >
                                    <div class="pr-6 pb-4 sm:w-1/2 w-full">
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
                                    <div class="pr-6 pb-4 sm:w-1/2 w-full">
                                        <InputLabel
                                            for="internShip"
                                            value="Stage"
                                        />

                                        <div class="form-input w-full block rounded">
                                            {{
                                                offer?.intern_ship?.title ??
                                                "-"
                                            }}
                                        </div>
                                    </div>

                                    <div class="pb-4 pr-6 w-full flex flex-col">
                                        <InputLabel
                                            for="description"
                                            value="Description *"
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
                                <div
                                    class="w-full"
                                    v-show="selectedTab === 'file'"
                                >
                                    <FileManager
                                        class="w-full"
                                        :attached-files="form.fileData"
                                        label-idle="Ajouter un(e) image/fichier"
                                        :allow-multiple="false"
                                        :allow-image-prewiew="true"
                                        @update-files="onUpdatePhoto"
                                    />
                                </div>
                                <div
                                    class="w-full"
                                    v-show="selectedTab === 'details'"
                                >
                                    <div class="w-full flex flex-col pb-4">
                                        <InputLabel
                                            for="requirements"
                                            value="Conditions *"
                                        />

                                        <Textarea
                                            id="requirements"
                                            v-model="form.requirements"
                                            name="requirements"
                                            placeholder="Ex: Nous sommes ..."
                                        >
                                        </Textarea>

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.requirements"
                                        />
                                    </div>
                                    <div class="w-full flex flex-col">
                                        <InputLabel
                                            for="responsibilities"
                                            value="Responsabilités"
                                        />

                                        <Textarea
                                            id="responsibilities"
                                            v-model="form.responsibilities"
                                            name="responsibilities"
                                            placeholder="Ex: Nous sommes ..."
                                        >
                                        </Textarea>

                                        <InputError
                                            class="mt-2"
                                            :message="
                                                form.errors.responsibilities
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-4 sm:px-6 py-4 flex justify-end items-center"
                            >
                                <InertiaLink
                                    :href="route('offers.index')"
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
        Textarea,
        FileManager,
        PrimaryButton,
        Multiselect,
    },

    layout: AppLayout,

    props: {
        offer: {
            type: Object,
            required: true,
        },
    },

    setup() {
        const { isEmptyString } = useStringUtilities();

        return { isEmptyString };
    },

    data() {
        return {
            selectedTab: "sheet",
            form: this.$inertia.form({
                responsibilities: this.offer.responsibilities ?? null,
                requirements: this.offer.requirements ?? null,
                title: this.offer.title ?? null,
                description: this.offer.description ?? null,
                intern_ship_id: this.offer.intern_ship_id ?? null,
                fileData: this.offer?.fileData ?? [],
            }),
        };
    },

    computed: {
        checkIfSubmitButtonShouldBeDisabled() {
            return (
                this.form.processing ||
                this.isEmptyString(this.form.title) ||
                this.isEmptyString(this.form.requirements) ||
                this.isEmptyString(this.form.description)
            );
        },
    },

    methods: {
        onUpdatePhoto(newFile) {
            this.form.fileData = newFile;
        },

        selectTheRightTab(event) {
            this.selectedTab = event.target.value;
        },

        submit() {
            this.form.put(`/offers/${this.offer.id}`, {
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

<style src="@vueform/multiselect/themes/default.css"></style>
