<template>
    <div v-show="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="link in links">
                <!-- eslint-disable vue/no-v-html, vue/no-v-text-v-html-on-component -->
                <div
                    v-if="link.url === null"
                    :key="link.id"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-black border rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :key="link.id + uuidv4Key"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-white': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
                <!-- eslint-enable vue/no-v-html, vue/no-v-text-v-html-on-component -->
            </template>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import { v4 as uuidv4 } from "uuid";

export default {
    components: {
        // eslint-disable-next-line vue/no-reserved-component-names
        Link,
    },

    props: {
        links: Array,
    },

    data: function () {
        return {
            uuidv4Key: uuidv4(),
        };
    },
};
</script>
