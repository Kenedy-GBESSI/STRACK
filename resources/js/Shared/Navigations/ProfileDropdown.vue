<template>
    <CustomMenu as="div" class="ml-3 relative">
        <div>
            <MenuButton
                class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none"
            >
                <span class="sr-only">Open user menu</span>
                <img
                    class="h-8 w-8 rounded-full"
                    :src="profilePhotoUrl"
                    :alt="'Avatar - ' + authUserFullName"
                />
                <!-- src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" -->
            </MenuButton>
        </div>
        <Transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems
                class="origin-top-right absolute z-[51] right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
                <MenuItem v-slot="{ active }">
                    <InertiaLink
                        :href="route('home')"
                        class="block px-4 py-2 text-sm text-gray-700"
                        :class="[active ? 'bg-gray-100' : '']"
                    >
                        {{ Dashboard }}
                    </InertiaLink>
                </MenuItem>

                <!-- Authentication -->
                <form class="w-full" @submit.prevent="logout">
                    <button
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"
                        role="menuitem"
                        tabindex="-1"
                        type="submit"
                    >
                        Déconnexion
                    </button>
                </form>
            </MenuItems>
        </Transition>
    </CustomMenu>
</template>

<script>
import {
    Menu as CustomMenu,
    MenuButton,
    MenuItem,
    MenuItems,
} from "@headlessui/vue";
import { Link as InertiaLink, router } from "@inertiajs/vue3";

export default {
    components: {
        CustomMenu,
        MenuButton,
        MenuItem,
        MenuItems,
        InertiaLink,
    },

    props: {
        authUserFullName: {
            type: String,
            required: true,
        },

        profilePhotoUrl: {
            type: String,
            required: true,
        },
    },

    methods: {
        logout() {
            // eslint-disable-next-line no-undef
            router.post(route("logout"));
        },
    },
};
</script>
