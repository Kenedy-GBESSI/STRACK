<template>
    <div
        class="min-h-screen flex flex-col overflow-hidden bg-[#F7F8FF] relative"
    >
        <header class="bg-[#007AED]">
            <nav
                class="max-w-screen-xl flex items-center justify-between mx-auto"
            >
                <div class="flex items-center flex-shrink-0 px-2">
                    <SidebarLogo :app-name="'Strack'" />
                </div>

                <button
                    data-collapse-toggle="navbar-dropdown"
                    type="button"
                    class="md:hidden -ml-4 px-3.5 inline-flex items-center justify-center rounded-md text-gray-100 hover:text-gray-200 focus:outline-none focus:ring-0 focus:ring-inset"
                    @click.prevent="sidebarOpen = true"
                >
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                </button>

                <div class="md:flex hidden sm:space-x-6 space-x-2 pr-2">
                    <InertiaLink
                        v-if="$page.props.auth.user.role === 'Student'"
                        :href="route('student.dashboard')"
                        class="text-[#F6F6F6] pt-0 pb-1 font-semibold"
                        :class="
                            isUrl('dashboard') ? 'border-b-2 border-white' : ''
                        "
                    >
                        Acceuil
                    </InertiaLink>
                    <InertiaLink
                        v-if="$page.props.auth.user.role === 'Student'"
                        :href="route('students.offers')"
                        class="text-[#F6F6F6] pt-0 pb-1 font-semibold"
                        :class="
                            isUrl('get-offers-for-students')
                                ? 'border-b-2 border-white'
                                : ''
                        "
                    >
                        Offres de stages
                    </InertiaLink>
                    <form class="inline" @submit.prevent="logout">
                        <button
                            class="text-[#F6F6F6] pt-0 pb-1 font-semibold"
                            role="menuitem"
                            tabindex="-1"
                            type="submit"
                        >
                            Déconnexion
                        </button>
                    </form>
                </div>

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
                                    <div
                                        class="absolute top-0 right-0 -mr-12 pt-2"
                                    >
                                        <button
                                            type="button"
                                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-fullx focus:outline-none"
                                            @click="sidebarOpen = false"
                                        >
                                            <span class="sr-only"
                                                >Close sidebar</span
                                            >
                                            <XMarkIcon
                                                class="h-6 w-6 text-white"
                                                aria-hidden="true"
                                            />
                                        </button>
                                    </div>
                                </TransitionChild>
                                <div
                                    class="flex-1 h-0 pt-5 pb-2 overflow-y-auto"
                                >
                                    <nav
                                        class="mt-5 px-2 flex flex-col space-y-3"
                                        aria-label="Sidebar"
                                    >
                                        <InertiaLink
                                            v-if="
                                                $page.props.auth.user.role ===
                                                'Student'
                                            "
                                            :href="route('student.dashboard')"
                                            class="text-[#F6F6F6] pt-0 pb-1 font-semibold"
                                            :class="
                                                isUrl('dashboard')
                                                    ? 'border-b-2 border-white'
                                                    : ''
                                            "
                                        >
                                            Acceuil
                                        </InertiaLink>
                                        <InertiaLink
                                            v-if="
                                                $page.props.auth.user.role ===
                                                'Student'
                                            "
                                            :href="route('students.offers')"
                                            class="text-[#F6F6F6] pt-0 pb-1 font-semibold"
                                            :class="
                                                isUrl('get-offers-for-students')
                                                    ? 'border-b-2 border-white'
                                                    : ''
                                            "
                                        >
                                            Offres de stages
                                        </InertiaLink>

                                        <form
                                            class="inline"
                                            @submit.prevent="logout"
                                        >
                                            <button
                                                class="text-[#F6F6F6] pt-0 pb-1 font-semibold"
                                                type="submit"
                                            >
                                                Déconnexion
                                            </button>
                                        </form>
                                    </nav>
                                </div>
                            </div>
                        </TransitionChild>
                        <div class="flex-shrink-0 w-14" aria-hidden="true">
                            <!-- Force sidebar to shrink to fit close icon -->
                        </div>
                    </CustomDialog>
                </TransitionRoot>
            </nav>
        </header>

        <main class="h-full relative z-0 overflow-y-auto focus:outline-none">
            <slot />
        </main>

        <div class="bg-[#007AED] absolute bottom-0 w-full">
            <p class="text-center text-white font-normal text-[18px]">
                &copy; Strack. Tous droits réservés.
            </p>
        </div>

        <Teleport to="body">
            <AlertHandler />
        </Teleport>
    </div>
</template>
<script>
import { defineAsyncComponent } from "vue";
import { Link as InertiaLink, router } from "@inertiajs/vue3";
import SidebarLogo from "@/Shared/Navigations/SidebarLogo.vue";
import { Bars3Icon } from "@heroicons/vue/24/outline";
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

const AlertHandler = defineAsyncComponent({
    loader: () => import("@/Shared/Notifications/AlertHandler.vue"),
});

export default {
    components: {
        AlertHandler,
        InertiaLink,
        CustomDialog,
        Bars3Icon,
        SidebarLogo,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        XMarkIcon,
        ChevronRightIcon,
    },

    data() {
        return {
            sidebarOpen: false,
        };
    },
    methods: {
        menuToggle() {
            this.$refs.menu.classList.toggle("active");
            this.closeBtn = !this.closeBtn;
        },

        isUrl(...urls) {
            let currentUrl = this.$page.url.slice(1);

            if (urls[0] === "") {
                return currentUrl === "";
            }

            return urls.filter((url) => currentUrl.startsWith(url)).length;
        },

        logout() {
            // eslint-disable-next-line no-undef
            router.post(route("logout"));
        },
    },
};
</script>

<style scoped></style>
