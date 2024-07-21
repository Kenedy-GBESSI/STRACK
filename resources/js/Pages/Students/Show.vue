<template>
    <div class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
        <div class="flex flex-col bg-[#FFFFFF]">
            <div class="flex flex-col p-6">
                <div class="flex flex-col space-y-4">
                    <div
                        class="flex sm:space-x-6 sm:space-y-0 space-x-1 space-y-4 px-4 flex-wrap sm:items-start items-center"
                    >
                        <InertiaLink
                            :href="route('students.index')"
                            class="flex justify-center items-center w-10 h-10 rounded-full bg-[#F4F4F4]"
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="flex-shrink-0 h-5 w-5 fa-light fa-arrow-left text-[#808080]"
                            />
                        </InertiaLink>
                        <div>
                            <h1 class="font-bold text-2xl leading-8">
                                {{ student?.last_name }}
                                {{ student?.first_name }}
                            </h1>
                            <p class="font-medium text-[#525252] leading-6">
                                {{ student?.matriculation_number }}
                            </p>
                        </div>
                        <span
                            class="flex justify-center items-center w-[110px] h-8 rounded"
                            :class="
                                student.internship_status === 'En stage'
                                    ? 'bg-[#4b9f0814] text-[#4B9F08]'
                                    : student.internship_status ===
                                        'Pas en stage'
                                      ? 'bg-[#f5737314] text-[#F57373]'
                                      : 'bg-[#f8950014] text-[#F89500]'
                            "
                        >
                            {{ student.internship_status ?? "-" }}</span
                        >
                        <span
                            v-if="student.internship_status === 'Fin de stage'"
                            class="flex justify-center items-center w-[110px] h-8 font-bold text-lg border border-[#145ee080] rounded-[24px] bg-[#E8F0FF] text-[#145EE0]"
                        >
                            Note: 18
                        </span>
                    </div>

                    <ul class="flex flex-col">
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Matricule
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.matriculation_number }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Nom
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.last_name }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Prénom
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.first_name }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Filière
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ student?.study_field }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Date de naissance
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                12-05-2002
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Email
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E] overflow-hidden text-ellipsis whitespace-nowrap"
                            >
                                {{ student?.email }}
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link as InertiaLink } from "@inertiajs/vue3";
import { defineAsyncComponent } from "vue";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

export default {
    components: {
        InertiaLink,
        FontAwesomeIcon,
    },

    layout: AppLayout,
    props: {
        student: Object,
    },

    data() {
        return {
            warningDelete: false,
            deleteString: "",
        };
    },
    methods: {},
};
</script>

<style scoped>
.title {
    padding: 0px 0px 16px;
    border-bottom: 1px solid #dadee3;
}
</style>
