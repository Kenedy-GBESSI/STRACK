<template>
    <Teleport to="body">
        <div v-if="alerts.length" class="fixed top-5 right-5 max-w-md z-50">
            <template v-for="customAlert in alerts" :key="customAlert.id">
                <div
                    class="rounded-md p-4 mb-4 duration-500 transition-all ease-in"
                    :class="{
                        'bg-green-200': customAlert.type === 'success',
                        'bg-yellow-200': customAlert.type === 'warning',
                        'bg-red-200': customAlert.type === 'danger',
                    }"
                >
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg
                                v-if="customAlert.type === 'success'"
                                class="h-5 w-5 text-green-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>

                            <svg
                                v-if="customAlert.type === 'warning'"
                                class="h-5 w-5 text-yellow-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>

                            <svg
                                v-if="customAlert.type === 'danger'"
                                class="h-5 w-5 text-red-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p
                                class="text-sm font-medium"
                                :class="{
                                    'text-green-900':
                                        customAlert.type === 'success',
                                    'text-yellow-900':
                                        customAlert.type === 'warning',
                                    'text-red-900':
                                        customAlert.type === 'danger',
                                }"
                            >
                                {{ customAlert.message }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button
                                    type="button"
                                    aria-label="Close"
                                    class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2"
                                    :class="{
                                        'bg-green-200 text-green-600 hover:bg-green-300 focus:ring-offset-green-100 focus:ring-green-600':
                                            customAlert.type === 'success',
                                        'bg-yellow-200 text-yellow-600 hover:bg-yellow-300 focus:ring-offset-yellow-100 focus:ring-yellow-600':
                                            customAlert.type === 'warning',
                                        'bg-red-200 text-red-600 hover:bg-red-300 focus:ring-offset-red-100 focus:ring-red-600':
                                            customAlert.type === 'danger',
                                    }"
                                    @click.prevent="
                                        removeAlert(customAlert.id, 0)
                                    "
                                >
                                    <span class="sr-only">Dismiss</span>
                                    <svg
                                        class="h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </Teleport>
</template>

<script setup>
import { computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import useAlerts from "@/Composables/useAlerts";

const alert = computed(() => usePage().props.flash.alert);
const { addAlert, alerts, removeAlert } = useAlerts();

watch(alert, (newVal) => {
    if (newVal) {
        addAlert(newVal);
    }
});
</script>
