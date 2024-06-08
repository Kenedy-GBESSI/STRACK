<template>
    <div>
        <InertiaHead title="Tableau de bord" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                    Yo <i class="fa-light fa-address-book"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head as InertiaHead } from "@inertiajs/vue3";
import Welcome from "@/Components/Welcome.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    components: {
        AppLayout,
        InertiaHead,
        Welcome,
    },

    layout: AppLayout,
};
</script>
