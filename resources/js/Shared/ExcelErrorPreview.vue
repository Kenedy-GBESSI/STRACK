<template>
    <div>
        <div
            v-if="errors.length > 0"
            class="w-full max-h-[30vh] overflow-auto no-scrollbar"
        >
            <h2 class="text-red-500 text-lg font-semibold pb-0.5">
                Erreurs d'importation
            </h2>
            <table
                class="min-w-full table-auto bg-red-50 border border-red-500"
            >
                <thead>
                    <tr class="bg-red-200">
                        <th class="px-4 py-2 border border-red-300 text-left">
                            Ligne
                        </th>
                        <th class="px-4 py-2 border border-red-300 text-left">
                            Attribut
                        </th>
                        <th class="px-4 py-2 border border-red-300 text-left">
                            Message d'erreur
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(error, index) in errors"
                        :key="index"
                        class="border-t border-red-300"
                    >
                        <td class="px-4 py-2 border border-red-300">
                            {{ error.row }}
                        </td>
                        <td class="px-4 py-2 border border-red-300">
                            {{ parseInt(error.attribute) + 1 }}
                        </td>
                        <td class="px-4 py-2 border border-red-300">
                            <ul>
                                <li
                                    v-for="(errorMsg, i) in error.errors"
                                    :key="i"
                                >
                                    {{ errorMsg }}
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        errors: {
            type: Array,
            required: false,
            default() {
                return [];
            },
        },
    },
};
</script>

<style scoped>
.no-scrollbar {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>
