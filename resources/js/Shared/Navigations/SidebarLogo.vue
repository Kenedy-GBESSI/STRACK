<template>
    <InertiaLink :href="route('home')" class="md:mx-auto">
        <div
            class="2xl:px-0 px-2 py-2 flex space-x-[10px] items-center justify-center"
        >
            <img
                :class="isMobile ? 'h-14 w-auto' : 'h-auto w-full'"
                src="../../../images/logo-strack.png"
                :alt="'Logo - ' + appName"
            />
            <p
                class="text-white 2xl:text-[38px] text-2xl font-bold tracking-[-0.76px] leading-normal"
            >
                STrack
            </p>
        </div>
        <div class="text-white">
          <p v-if="$page.props.auth.user.role === 'Institute'" class="font-bold text-center">IFRI</p>
          <p  v-if="$page.props.auth.user.role === 'Company'" class="font-bold">{{ truncateText($page.props.auth.user?.profile?.company_name, 10) }} </p>
        </div>
    </InertiaLink>
</template>

<script>

import { Link as InertiaLink } from "@inertiajs/vue3";
import useStringUtilities from "@/Composables/stringUtilities.js";

export default {
    components: {
        InertiaLink,
    },

    props: {
        appName: {
            type: String,
            required: true,
        },

        isMobile: {
            type: Boolean,
            default: false,
        },
    },

    setup() {
        const { truncateText } = useStringUtilities();

        return { truncateText };
    },
};
</script>
