<template>
    <div
        :class="isMobile ? 'p-4' : 'px-2 py-4'"
        class="flex flex-shrink-0 border-t border-indigo-800"
    >
        <div class="flex-shrink-0 group block w-full">
            <div class="flex items-center justify-between">
                <div>
                    <InertiaLink :href="route('profile.show')">
                        <p
                            :class="isMobile ? 'text-xs' : 'text-sm'"
                            class="font-semibold text-secondary"
                        >
                            {{ authUserFullName }}
                        </p>
                    </InertiaLink>
                    <p class="text-xs font-medium text-indigo-200">
                        v {{ appVersion }}
                    </p>
                </div>
                <div
                    :class="isMobile ? 'text-xs' : 'text-sm'"
                    class="text-secondary font-medium"
                >
                    <InertiaLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                        type="button"
                        title="Déconnexion"
                        class="group"
                    >
                        <span class="sr-only">Déconnexion</span>
                        <div
                            class="bg-indigo-800/[0.90] group-hover:bg-indigo-700/[0.70] rounded-full p-2"
                        >
                            <ArrowRightOnRectangleIcon
                                class="h-5 w-5 text-secondary"
                            />
                        </div>
                    </InertiaLink>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link as InertiaLink, router } from "@inertiajs/vue3";
import { ArrowRightOnRectangleIcon } from "@heroicons/vue/24/outline";
export default {
    components: {
        InertiaLink,
        ArrowRightOnRectangleIcon,
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

        isMobile: {
            type: Boolean,
            default: false,
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
