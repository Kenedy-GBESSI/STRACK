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
                            v-if="$page.props.auth.user.role === 'Company'"
                            :href="route('company.dashboard')"
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('dashboard')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-chart-pie"
                            />

                            Tableau de bord
                        </InertiaLink>

                        <InertiaLink
                            v-if="$page.props.auth.user.role === 'Institute'"
                            :href="route('institute.dashboard')"
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('dashboard')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-chart-pie"
                            />

                            Tableau de bord
                        </InertiaLink>
                        <InertiaLink
                            v-if="$page.props.auth.user.role === 'Institute'"
                            :href="route('students.index')"
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('students')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-users"
                            />

                            Étudiants
                        </InertiaLink>
                        <InertiaLink
                            v-if="$page.props.auth.user.role === 'Institute'"
                            :href="route('companies.index')"
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('companies')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-building-columns"
                            />

                            Entreprises
                        </InertiaLink>
                        <InertiaLink
                            v-if="
                                $page.props.auth.user.role === 'Institute' ||
                                $page.props.auth.user.role === 'Company'
                            "
                            :href="route('intern-ships.index')"
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('intern-ships')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
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
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('offers')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
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
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('candidacies')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="mr-4 flex-shrink-0 h-6 w-6 text-white group-hover:text-white fa-light fa-user-check"
                            />

                            Candidatures
                        </InertiaLink>

                        <InertiaLink
                            v-if="$page.props.auth.user.role === 'Company'"
                            :href="route('interns')"
                            class="group w-full text-[#F6F6F6] flex items-center h-12 pl-4 py-3 text-sm font-semibold hover:bg-[#268FF2]"
                            :class="
                                isUrl('interns')
                                    ? 'border-l-2 border-white  bg-[#268FF2]'
                                    : ''
                            "
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
