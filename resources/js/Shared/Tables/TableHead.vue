<template>
    <thead>
        <tr class="py-4 px-2">
            <th
                v-for="(headerName, i) in header"
                :key="i"
                scope="col"
                class="px-2 py-4 text-left text-xs font-bold text-[#6B7A99] uppercase tracking-wider"
            >
                {{ headerName }}
            </th>
            <th
                scope="col"
                class="px-2 py-4 text-left text-xs font-bold text-[#6B7A99] uppercase tracking-wider"
            >
                Action
            </th>
        </tr>
    </thead>
</template>

<script>
export default {
    props: {
        header: {
            type: Array,
            required: true,
            validator(value) {
                return value.length !== 0;
            },
        },

        hasActions: {
            type: Boolean,
            required: false,
            default: true,
        },
    },
};
</script>
