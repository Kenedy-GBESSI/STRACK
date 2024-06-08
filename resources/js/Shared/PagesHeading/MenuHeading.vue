<template>
    <div
        class="flex items-center justify-between px-6 bg-white border-b border-[#F8F8F8] w-full"
    >
        <h1
            class="text-xl leading-8 tracking-tight text-gray-700 sm:text-2xl font-bold"
        >
            {{ indexTitle }}
        </h1>
    </div>
</template>

<script>
import { Link as InertiaLink } from "@inertiajs/vue3";
import isNil from "lodash/isNil";

export default {
    components: {
        InertiaLink,
    },

    props: {
        indexTitle: {
            type: String,
            required: true,
            validator: function (value) {
                return !isNil(value);
            },
        },
    },
};
</script>
