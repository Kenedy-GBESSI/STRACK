<template>
    <div
        v-show="showSendReportModal"
        class="fixed z-50 inset-0 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
            />

            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
                >&#8203;</span
            >

            <form
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full"
                @submit.prevent="sendInternShipReport"
            >
                <div class="pt-4 px-6 w-full">
                    <InputLabel class="mb-1" for="cv" value="Rapport de Stage (NB: Un nouveau rapport envoyé annulera celui envoyé précedemment) :" />
                    <FileManager
                        class="w-full"
                        :attached-files="form.fileData"
                        label-idle="Ajouter un fichier"
                        :allow-multiple="false"
                        :allow-image-prewiew="true"
                        @update-files="onUpdateFile"
                    />
                    <InputError class="mt-2" :message="form.errors.fileData" />
                </div>
                <div
                    class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse sm:space-y-0 space-y-2"
                >
                    <button
                        id="confirmDialog"
                        type="submit"
                        :disabled="checkIfSubmitButtonShouldBeDisabled"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <template v-if="form.processing">
                            <div class="mr-2">
                                <svg
                                    class="animate-spin -ml-1 mr-1 h-5 w-5 text-white inline-block"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                            </div>
                        </template>
                        Envoyer
                    </button>
                    <button
                        type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="closeSendReportModal()"
                    >
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import useStringUtilities from "@/Composables/stringUtilities.js";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FileManager from "@/Shared/FileManager.vue";
import isEmpty from "lodash/isEmpty";

export default {
    components: {
        TextInput,
        InputLabel,
        FileManager,
        InputError,
    },

    props: {
        show: {
            type: Boolean,
            default: false,
        },

        studentInternShipId: {
            type: [Number, String],
        },
    },

    emits: ["updateSendReportModal"],

    setup() {
        const { isEmptyString } = useStringUtilities();

        return {
            isEmptyString,
        };
    },

    data() {
        return {
            form: this.$inertia.form({
                fileData: [],
            }),
        };
    },

    computed: {
        showSendReportModal: {
            get() {
                return this.show;
            },

            set(newValue) {
                this.$emit("updateSendReportModal", newValue);
            },
        },

        checkIfSubmitButtonShouldBeDisabled() {
            return (
                isEmpty(this.form.fileData) ||
                this.isEmptyString(this.studentInternShipId)
            );
        },
    },

    watch: {},

    methods: {
        closeSendReportModal() {
            if (this.form.processing) {
                console.warn(`Please, wait! the form is still processing`);

                return;
            }

            this.showSendReportModal = false;

            if (this.form.hasErrors) {
                this.form.clearErrors();
            }

            this.resetFormToInitialData();
        },

        resetFormToInitialData() {
            this.form.fileData = [];
        },

        onUpdateFile(newFile) {
            this.form.fileData = newFile;
        },

        sendInternShipReport() {
            this.form.post(
                `/student-intern-ship/${this.studentInternShipId}/rapport`,
                {
                    preserveScroll: true,
                    preserveState: true,
                    onBefore: () => {
                        if (this.form.hasErrors) {
                            this.form.clearErrors();
                        }

                        if (this.checkIfSubmitButtonShouldBeDisabled) {
                            return false;
                        }
                    },
                    onSuccess: () => {
                        return Promise.all([this.closeSendReportModal()]);
                    },
                },
            );
        },
    },
};
</script>
