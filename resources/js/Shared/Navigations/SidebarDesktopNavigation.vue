<template>
    <!-- Static sidebar for desktop -->
    <div
        class="hidden bg-[#007AED] md:flex md:flex-shrink-0 border-r-4 border-secondary pt-3.5"
    >
        <div class="flex flex-col w-64">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex flex-col h-0 flex-1">
                <div
                    class="flex-1 flex flex-col pt-5x pt-1 pb-4 overflow-y-auto"
                >
                    <div class="flex items-center flex-shrink-0 px-2">
                        <SidebarLogo :app-name="appName" />
                    </div>
                    <nav
                        class="mt-4 flex-1 space-y-2 overflow-x-hidden"
                        aria-label="Sidebar"
                    >
                        <InertiaLink
                            :href="route('dashboard')"
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold border"
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="mr-4 flex-shrink-0 h-6 w-6"
                            />

                            Dashboard
                        </InertiaLink>
                    </nav>
                </div>

                <SidebarFooter
                    :auth-user-full-name="authUserFullName"
                    :app-version="appVersion"
                />
            </div>
        </div>
    </div>
    <!-- End Static sidebar for desktop -->
</template>

<script>
import { defineAsyncComponent, ref } from "vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronRightIcon } from "@heroicons/vue/24/outline";
import { Link as InertiaLink } from "@inertiajs/vue3";
import SidebarFooter from "@/Shared/Navigations/SidebarFooter.vue";
import SidebarLogo from "@/Shared/Navigations/SidebarLogo.vue";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

export default {
    components: {
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
    },

    data() {
        return {};
    },
};
</script>
