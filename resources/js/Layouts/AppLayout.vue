<template>
    <div class="h-screen flex overflow-hidden bg-[#F7F8FF]">
        <div id="dropdown" />

        <SidebarMobileNavigation
            :app-name="appName"
            :app-version="appVersion"
            :auth-user-full-name="authUserFullName"
            :sidebar-open-status="sidebarOpen"
            @sidebar-open-status-updated="onSidebarOpenStatusUpdated"
        />

        <SidebarDesktopNavigation
            :app-name="appName"
            :app-version="appVersion"
            :auth-user-full-name="authUserFullName"
        />

        <div class="flex flex-col w-0 flex-1 overflow-x-hidden">
            <SidebarMobileMenu
                :auth-user-full-name="authUserFullName"
                :profile-photo-url="profilePhotoUrl"
                :sidebar-open-status="sidebarOpen"
                @sidebar-open-status-updated="onSidebarOpenStatusUpdated"
            />

            <div class="relative">
                <MenuHeading
                    :index-title="getCurrentRouteName"
                    class="h-24 inset-0 z-40"
                />
                <main class="relative z-0 overflow-y-auto focus:outline-none">
                    <slot />
                </main>
            </div>
        </div>

        <Teleport to="body">
            <AlertHandler />
        </Teleport>
    </div>
</template>

<script>
import { defineAsyncComponent, ref } from "vue";
import SidebarDesktopNavigation from "@/Shared/Navigations/SidebarDesktopNavigation.vue";
import MenuHeading from "@/Shared/PagesHeading/MenuHeading.vue";
import useNavigationsData from "@/Composables/navigationsWithChildrenData";

const AlertHandler = defineAsyncComponent({
    loader: () => import("@/Shared/Notifications/AlertHandler.vue"),
});

const SidebarMobileNavigation = defineAsyncComponent({
    loader: () => import("@/Shared/Navigations/SidebarMobileNavigation.vue"),
});

const SidebarMobileMenu = defineAsyncComponent({
    loader: () => import("@/Shared/Navigations/SidebarMobileMenu.vue"),
});

export default {
    components: {
        AlertHandler,
        SidebarDesktopNavigation,
        SidebarMobileMenu,
        SidebarMobileNavigation,
        MenuHeading,
    },

    setup() {
        const sidebarOpen = ref(false);
        const { navigationsWithChildren } = useNavigationsData();

        return {
            sidebarOpen,
            navigationsWithChildren,
        };
    },

    data() {
        return {};
    },

    computed: {
        appName() {
            return this.$page.props.shared_values.app_name;
        },

        authUserFullName() {
            return this.$page.props.auth.user.full_name;
        },

        appVersion() {
            return this.$page.props.shared_values.app_version;
        },

        profilePhotoUrl() {
            return this.$page.props.auth.user.profile_photo_url;
        },

        getCurrentRouteName() {
            const currentUrl = this.$page.url.slice(1);

            const matchingNavigation = this.navigationsWithChildren.find(
                (nav) => currentUrl.startsWith(nav.route),
            );

            return matchingNavigation ? matchingNavigation.name : null;
        },
    },

    methods: {
        onSidebarOpenStatusUpdated(updatedSidebarOpenStatus) {
            this.sidebarOpen = updatedSidebarOpenStatus;
        },
    },
};
</script>
