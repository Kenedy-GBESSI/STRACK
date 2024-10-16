<template>
    <div v-show="showFullScreenModal">
        <Teleport to="body">
            <FullScreenDialog
                :show="showFullScreenModal"
                :title="'Importer un fichier excel'"
                @close="closeFullScreenModal()"
            >
                <div
                    class="flex w-full flex-col mt-2 justify-center items-center"
                >
                    <div class="sm:w-1/2 w-full sm:mx-0 mx-4">
                        <FileManager
                            class="w-full"
                            :is-required="true"
                            :attached-files="form.importData"
                            :accepted-file-types="'.xls, .xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'"
                            label-idle="Ajouter ou glisser un fichier excel"
                            :is-excel-file="true"
                            :allow-multiple="false"
                            @update-files="onUpdateImportData"
                            @selected-excel-file="onSelectedFile"
                        />
                    </div>

                    <ExcelPreview
                        v-if="selectedFile"
                        class="sm:w-1/2 w-full sm:mx-0 mx-4"
                        :selected-file="selectedFile"
                    />

                    <ExcelErrorPreview
                        v-if="errors.length > 0"
                        class="mt-4 sm:w-1/2 w-full sm:mx-0 mx-4"
                        :errors="errors"
                    />
                    <div
                        class="py-4 sm:w-1/2 w-full sm:mx-0 mx-4 flex justify-end items-center"
                    >
                        <PrimaryButton
                            :disabled="checkIfSubmitButtonShouldBeDisabled"
                            type="submit"
                            @click.prevent="importItemFile()"
                        >
                            Importer
                        </PrimaryButton>
                    </div>
                </div>
            </FullScreenDialog>
        </Teleport>
    </div>
</template>

<script>
import FullScreenDialog from "@/Components/FullScreenDialog.vue";
import PrimaryButton from "@/Shared/PrimaryButton.vue";
import FileManager from "@/Shared/FileManager.vue";
import isEmpty from "lodash/isEmpty";
import ExcelPreview from "@/Shared/ExcelPreview.vue";
import ExcelErrorPreview from "@/Shared/ExcelErrorPreview.vue";
import axios from "axios";
import useAlerts from "@/Composables/useAlerts";

export default {
    components: {
        FullScreenDialog,
        PrimaryButton,
        FileManager,
        ExcelPreview,
        ExcelErrorPreview,
    },

    props: {
        openFullScreenModal: {
            type: Boolean,
            default: false,
        },
    },

    emits: {
        updateFullScreenModalStatus: (status) => {
            if (typeof status === "boolean") {
                return true;
            }

            console.warn(`Invalid modal submission name!`);
            return false;
        },
    },

    setup() {
        const { addAlert } = useAlerts();

        return { addAlert };
    },

    data() {
        return {
            form: {
                importData: [],
            },

            selectedFile: null,
            errors: [],
        };
    },

    computed: {
        showFullScreenModal: {
            get() {
                return this.openFullScreenModal;
            },

            set(newStatus) {
                this.$emit("updateFullScreenModalStatus", newStatus);
            },
        },

        checkIfSubmitButtonShouldBeDisabled() {
            return isEmpty(this.form.importData);
        },
    },

    watch: {},

    methods: {
        onUpdateImportData(newFile) {
            this.form.importData = newFile;
        },

        closeFullScreenModal() {
            this.showFullScreenModal = false;
        },

        importItemFile() {
            axios
                .post(this.route("students.import"), this.form)
                .then((response) => {
                    if (response.data.success) {
                        this.$inertia.reload();

                        this.closeFullScreenModal();

                        this.addAlert({
                            type: "success",
                            message:
                                "Les données ont été importées avec succès.",
                            duration: null,
                        });
                        
                    } else {
                        this.errors = response.data.errors;
                    }
                })
                .catch((error) => {
                    console.error("Erreur lors de l'importation : ", error);
                });
        },

        onSelectedFile(file) {
            this.selectedFile = file;
            this.errors = [];
        },
    },
};
</script>
