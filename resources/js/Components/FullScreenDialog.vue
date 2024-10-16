<template>
    <transition
        enter-from-class="opacity-0"
        leave-to-class="opacity-0"
        enter-active-class="transition duration-500"
        leave-active-class="transition duration-500"
    >
        <div
            v-if="show"
            class="fixed inset-0 z-10 overflow-y-auto bg-gray-800 bg-opacity-75 flex justify-center items-center"
        >
            <div class="bg-slate-100 w-full h-full p-6 rounded-lg shadow-lg">
                <!-- Header section with title and close button -->
                <slot name="title">
                    <div class="pb-4 mt-2 flex items-center justify-between">
                        <h1
                            class="text-2xl leading-5 tracking-tight text-gray-700 sm:text-3xl font-bold"
                        >
                            {{ title }}
                        </h1>

                        <button
                            type="button"
                            class="sm:hidden p-1 bg-[#007AED] text-white rounded-lg border border-transparent shadow-sm hover:bg-indigo-800 focus:bg-indigo-800 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition ease-in-out duration-150"
                            @click="closeModal()"
                        >
                            <PlusSmallIcon class="w-5 h-5 rotate-45" />
                            <span class="sr-only">Fermer</span>
                        </button>

                        <div class="sm:ml-4 hidden sm:block">
                            <button
                                type="button"
                                class="inline-flex items-center mt-3 sm:mt-0 px-2.5 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#007AED] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                @click="closeModal()"
                            >
                                <PlusSmallIcon
                                    class="h-4 w-4 hidden sm:block rotate-45"
                                />
                                <span class="pl-1">Fermer</span>
                            </button>
                        </div>
                    </div>
                </slot>
                <div class="h-[calc(100%-150px)] overflow-auto">
                    <slot />
                </div>
                <slot name="foot" />
            </div>
        </div>
    </transition>
</template>

<script>
import { PlusSmallIcon } from "@heroicons/vue/24/outline";

export default {
    components: { PlusSmallIcon },
    props: {
        show: {
            type: Boolean,
            required: true,
        },

        title: String,
    },

    emits: ["close"],

    methods: {
        closeModal() {
            this.$emit("close");
        },
    },
};
</script>
