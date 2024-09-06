<template>
    <div class="cursor-pointer">
        <FilePond
            name="file"
            :label-idle="labelIdle"
            :allow-multiple="allowMultiple"
            :allow-image-preview="allowImagePrewiew"
            :required="false"
            :disabled="disabled"
            :accepted-file-types="acceptedFileTypes"
            :server="serverOptions"
            :files="attachedFiles"
            :before-remove-file="beforeRemove"
            @init="handleFilePondInit"
            @processfile="processFile"
            @removefile="removeFile"
            @addfile="addFile"
        />
        <Teleport to="body">
            <ConfirmationDialog
                v-if="showConfirmationModal"
                :message="message"
                :title="title"
                :show="show.default"
                :closeable="closeable"
                @confirm="confirm()"
                @close="close()"
            />
        </Teleport>
    </div>
</template>

<script>
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import "filepond-plugin-image-pdf-overlay/dist/filepond-plugin-image-overlay.min.css";
import FilePondPluginImageOverlay from "filepond-plugin-image-pdf-overlay";
import "filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css";
import FilePondPluginGetFile from "filepond-plugin-get-file";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import ConfirmationDialog from "@/Shared/ConfirmationDialog.vue";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImageOverlay,
    FilePondPluginGetFile,
    FilePondPluginFileValidateSize,
    FilePondPluginImagePreview,
);

export default {
    components: {
        FilePond,
        ConfirmationDialog,
    },

    props: {
        attachedFiles: Array,
        serverOptions: {
            type: [Object, String],
            default() {
                return "/filepond/api/process";
            },
        },

        allowImagePrewiew: {
            type: Boolean,
            default: false,
        },

        allowMultiple: {
            type: Boolean,
            default: true,
        },

        labelIdle: {
            type: String,
            default: "Glisser - Déposer les fichiers...",
        },

        acceptedFileTypes: {
            type: String,
            default:
                "image/jpeg, image/png, application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, .csv",
        },

        disabled: {
            type: Boolean,
            default: false,
        },
    },

    emits: ["updateFiles", "update:attachedFiles"],

    data() {
        return {
            mutableFiles: this.attachedFiles,
            showConfirmationModal: false,
            message: null,
            title: null,
            show: {
                default: true,
            },

            closeable: {
                default: true,
            },

            promise: null,
        };
    },

    watch: {
        mutableFiles: {
            handler(updatedFiles) {
                this.$emit("updateFiles", updatedFiles);
                this.$emit("update:attachedFiles", updatedFiles);
            },

            deep: true,
        },
    },

    methods: {
        handleFilePondInit: function () {},
        processFile(event, file) {
            if (file.origin !== 2) {
                if (!this.allowMultiple) {
                    this.mutableFiles.splice(0, this.mutableFiles.length);
                    this.mutableFiles.push({
                        id: file.id,
                        server_id: file.serverId,
                    });
                } else {
                    this.mutableFiles.push({
                        id: file.id,
                        server_id: file.serverId,
                    });
                }
            }
        },

        removeFile: function (event, file) {
            for (let i = 0; i < this.mutableFiles.length; i++) {
                let isInTheMutableFile =
                    file.serverId === this.mutableFiles[i].server_id ||
                    file.serverId === this.mutableFiles[i].source;
                if (isInTheMutableFile) {
                    this.mutableFiles.splice(i, 1);
                    break;
                }
            }
        },

        addFile() {},
        async beforeRemove() {
            this.title = "Confirmation de suppression";
            this.message = "Êtes-vous sûr de vouloir supprimer ce fichier?";
            this.showConfirmationModal = true;
            this.show.default = true;
            this.promise = new Promise((resolve, reject) => {
                window.onclick = function (event) {
                    if (event.target.id === "confirmDialog") {
                        if (!this.showModal) {
                            resolve("success");
                        } else {
                            reject("fail");
                        }
                    }
                };
            });
            let result = await this.promise;
            return result === "success" ? true : false;
        },

        confirm() {
            this.showConfirmationModal = false;
        },

        close() {
            this.showConfirmationModal = false;
        },
    },
};
</script>
