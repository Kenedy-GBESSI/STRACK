<template>
    <!-- Sidebar block for mobile navigation -->
    <TransitionRoot as="template" :show="sidebarOpen">
        <CustomDialog
            as="div"
            static
            class="fixed inset-0 flex z-40 md:hidden"
            :open="sidebarOpen"
            @close="sidebarOpen = false"
        >
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <DialogOverlay
                    class="fixed inset-0 bg-gray-600 bg-opacity-75"
                />
            </TransitionChild>
            <TransitionChild
                as="template"
                enter="transition ease-in-out duration-300 transform"
                enter-from="-translate-x-full"
                enter-to="translate-x-0"
                leave="transition ease-in-out duration-300 transform"
                leave-from="translate-x-0"
                leave-to="-translate-x-full"
            >
                <div
                    class="relative flex-1 flex flex-col max-w-xs w-full bg-[#007AED]"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-in-out duration-300"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="ease-in-out duration-300"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="absolute top-0 right-0 -mr-12 pt-2">
                            <button
                                type="button"
                                class="ml-1 flex items-center justify-center h-10 w-10 rounded-fullx focus:outline-none"
                                @click="sidebarOpen = false"
                            >
                                <span class="sr-only">Close sidebar</span>
                                <XMarkIcon
                                    class="h-6 w-6 text-white"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>
                    </TransitionChild>
                    <div class="flex-1 h-0 pt-5 pb-2 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-4">
                            <SidebarLogo :app-name="appName" is-mobile />
                        </div>
                        <nav class="mt-5 px-2 space-y-1" aria-label="Sidebar">
                            <InertiaLink
                                :href="route('dashboard')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md border"
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-xl"
                                    class="mr-4 flex-shrink-0 h-6 w-6"
                                />
                                Dashboard
                            </InertiaLink>
                        </nav>
                    </div>
                    <SidebarFooter
                        is-mobile
                        :app-version="appVersion"
                        :auth-user-full-name="authUserFullName"
                    />
                </div>
            </TransitionChild>
            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </CustomDialog>
    </TransitionRoot>
    <!-- End Sidebar block for mobile navigation -->
</template>

<script>
import { defineAsyncComponent } from "vue";
import {
    Dialog as CustomDialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
} from "@headlessui/vue";
import { XMarkIcon, ChevronRightIcon } from "@heroicons/vue/24/outline";
import { Link as InertiaLink } from "@inertiajs/vue3";
import SidebarFooter from "@/Shared/Navigations/SidebarFooter.vue";
import SidebarLogo from "@/Shared/Navigations/SidebarLogo.vue";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

export default {
    components: {
        CustomDialog,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
        XMarkIcon,
        ChevronRightIcon,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        InertiaLink,
        SidebarFooter,
        SidebarLogo,
        FontAwesomeIcon,
    },

    props: {
        authUserFullName: {
            type: String,
            required: true,
        },

        appVersion: {
            type: String,
            required: true,
        },

        appName: {
            type: String,
            required: true,
        },

        sidebarOpenStatus: {
            type: Boolean,
            required: true,
        },
    },

    emits: { sidebarOpenStatusUpdated: null },

    data() {
        return {};
    },

    computed: {
        sidebarOpen: {
            get() {
                return this.sidebarOpenStatus;
            },

            set(newStatus) {
                this.$emit("sidebarOpenStatusUpdated", newStatus);
            },
        },
    },
};
</script>
