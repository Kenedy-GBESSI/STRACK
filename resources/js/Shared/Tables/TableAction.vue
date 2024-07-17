<template>
    <Dropdown :overlay="false" direction="right">
        <template #trigger>
            <button>
                <img
                    src="@/Assets/icons/trois_points.svg"
                    alt=""
                    class="anchor cursor-pointer"
                />
            </button>
        </template>

        <template #content>
            <ul class="divide-y divide-gray-300">
                <li
                    v-for="(action, ind) in actions"
                    :key="ind"
                    class="w-full p-2"
                >
                    <InertiaLink
                        v-if="action === 'show' && baseRouteName"
                        :href="route(`${baseRouteName}.show`, resource?.id)"
                        class="text-sm font-semibold text-[#268FF2]"
                    >
                        Voir
                    </InertiaLink>
                    <InertiaLink
                        v-if="action === 'update' && baseRouteName"
                        :href="route(`${baseRouteName}.edit`, resource?.id)"
                        class="text-sm font-semibold text-[#268FF2]"
                    >
                        Mettre à jour
                    </InertiaLink>
                    <button
                        v-if="action === 'destroy' && baseRouteName"
                        @click="destroy(resource)"
                        class="text-sm font-semibold text-[#f23a26] w-full text-left"
                    >
                        Supprimer
                    </button>
                </li>
            </ul>
        </template>
    </Dropdown>
</template>

<script>
import Dropdown from "@/Components/Dropdown.vue";
import isObject from "lodash/isObject";
import isEmpty from "lodash/isEmpty";
import { Link as InertiaLink } from "@inertiajs/vue3";

export default {
    components: {
        Dropdown,
        InertiaLink,
    },

    props: {
        actions: {
            type: Array,
            required: true,
            validator(value) {
                return value.length !== 0;
            },
        },

        resource: {
            type: Object,
            required: true,
            validator(value) {
                return isObject(value) && !isEmpty(value);
            },
        },

        baseRouteName: {
            type: String,
            required: false,
        },
    },

    methods: {
        destroy(resource){
            this.$inertia.delete(`/${this.baseRouteName}/${resource.id}`);
        }
    }
};
</script>
