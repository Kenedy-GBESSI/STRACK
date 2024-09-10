<template>
    <div
        v-show="show"
        class="fixed z-10 inset-0 overflow-y-auto"
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

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10"
                        >
                            <svg
                                class="h-6 w-6 text-green-600"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14h.01m-1.01-1.01L11 7h2l-.01 7h-1.99z"
                                />
                            </svg>
                        </div>
                        <div class="mt-3 m:mt-0 sm:ml-4 text-left w-full">
                            <h3
                                id="modal-title"
                                class="text-lg leading-6 font-medium text-gray-900"
                            >
                                NOTER LE STAGIAIRE
                            </h3>
                            <div class="mt-4 w-full">
                                <div class="mb-2 w-full">
                                    <div class="font-bold">Note:</div>
                                    <TextInput
                                        id="company_note"
                                        ref="company_note"
                                        v-model="company_note"
                                        type="number"
                                        step="1"
                                        min="5"
                                        max="17"
                                        name="company_note"
                                        class="block w-full"
                                    />
                                    <div
                                        v-if="
                                            company_note &&
                                            (company_note < 5 ||
                                                company_note > 17)
                                        "
                                        class="form-error text-red-500"
                                    >
                                        Attention ! La note doit être comprise
                                        entre 5 et 17
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                >
                    <button
                        id="confirmDialog"
                        :disabled="disableButton"
                        type="submit"
                        class="w-full disabled:opacity-60 disabled:cursor-not-allowed inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 mb-4 sm:mb-0 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="confirm()"
                    >
                        Noter
                    </button>
                    <button
                        v-if="canClose"
                        type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="close()"
                    >
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TextInput from "@/Components/TextInput.vue";
import useStringUtilities from "@/Composables/stringUtilities.js";

export default {
    components: {
        TextInput,
    },

    props: {
        show: {
            type: Boolean,
            default: false,
        },

        canClose: {
            type: Boolean,
            default: true,
        },
    },

    emits: ["confirm", "close"],

    setup() {
        const { isEmptyString } = useStringUtilities();

        return { isEmptyString };
    },

    data() {
        return {
            company_note: null,
        };
    },

    computed: {
        disableButton() {
            return (
                this.isEmptyString(this.company_note) ||
                this.company_note < 5 ||
                this.company_note > 17
            );
        },
    },

    mounted() {
        this.$refs.company_note.focus();
    },

    methods: {
        confirm() {
            if (this.disableButton) {
                return;
            }

            this.$emit("confirm", this.company_note);
        },

        close() {
            this.$emit("close");
        },
    },
};
</script>
