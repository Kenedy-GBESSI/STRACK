<template>
    <!-- Static sidebar for Profile menu mobile -->
    <div class="md:hidden bg-[#007AED]">
        <div class="flex-1 px-4 flex items-center justify-between h-16">
            <button
                type="button"
                class="-ml-4 px-3.5 inline-flex items-center justify-center rounded-md text-gray-100 hover:text-gray-200 focus:outline-none focus:ring-0 focus:ring-inset"
                @click="sidebarOpen = true"
            >
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>

            <div class="ml-4 flex items-center md:ml-6">
                <!-- Profile dropdown -->
                <ProfileDropdown
                    :auth-user-full-name="authUserFullName"
                    :profile-photo-url="profilePhotoUrl"
                />
            </div>
        </div>
    </div>
    <!-- End Static sidebar Profile menu for mobile -->
</template>

<script>
import { Bars3Icon } from "@heroicons/vue/24/outline";
import ProfileDropdown from "@/Shared/Navigations/ProfileDropdown.vue";

export default {
    components: {
        ProfileDropdown,
        Bars3Icon,
    },

    props: {
        sidebarOpenStatus: {
            type: Boolean,
            required: true,
        },

        authUserFullName: {
            type: String,
            required: true,
        },

        profilePhotoUrl: {
            type: String,
            required: true,
        },
    },

    emits: { sidebarOpenStatusUpdated: null },
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
