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
                                v-if="
                                    $page.props.auth.user.role === 'Company'
                                "
                                :href="route('company.dashboard')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('dashboard')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-chart-pie"
                                />

                                Tableau de bord
                            </InertiaLink>

                            <InertiaLink
                                v-if="
                                    $page.props.auth.user.role === 'Institute'
                                "
                                :href="route('institute.dashboard')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('dashboard')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-chart-pie"
                                />

                                Tableau de bord
                            </InertiaLink>
                            <InertiaLink
                                v-if="
                                    $page.props.auth.user.role === 'Institute'
                                "
                                :href="route('students.index')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('students')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-users"
                                />

                                Étudiants
                            </InertiaLink>
                            <InertiaLink
                                v-if="
                                    $page.props.auth.user.role === 'Institute'
                                "
                                :href="route('companies.index')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('companies')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-building-columns"
                                />

                                Entreprises
                            </InertiaLink>
                            <InertiaLink
                                v-if="
                                    $page.props.auth.user.role ===
                                        'Institute' ||
                                    $page.props.auth.user.role === 'Company'
                                "
                                :href="route('intern-ships.index')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('intern-ships')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-graduation-cap"
                                />

                                Stages
                            </InertiaLink>
                            <InertiaLink
                                v-if="$page.props.auth.user.role === 'Company'"
                                :href="route('offers.index')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('offers')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-handshake"
                                />

                                Offres
                            </InertiaLink>
                            <InertiaLink
                                v-if="$page.props.auth.user.role === 'Company'"
                                :href="route('candidacies')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('candidacies')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-user-check"
                                />

                                Candidatures
                            </InertiaLink>
                            <InertiaLink
                                v-if="
                                    $page.props.auth.user.role === 'Company'
                                "
                                :href="route('interns')"
                                class="group text-white w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md"
                                :class="
                                    isUrl('interns')
                                        ? 'border-l-2 border-white  bg-[#268FF2]'
                                        : ''
                                "
                                @click="sidebarOpen = false"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-users"
                                />

                                Stagiaires
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

    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.slice(1);

            if (urls[0] === "") {
                return currentUrl === "";
            }

            return urls.filter((url) => currentUrl.startsWith(url)).length;
        },
    },
};
</script>
