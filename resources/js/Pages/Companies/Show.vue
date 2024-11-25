<template>
    <div class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
        <div class="flex flex-col bg-[#FFFFFF]">
            <div class="flex flex-col p-6">
                <div class="flex flex-col space-y-4">
                    <div
                        class="flex sm:space-x-6 sm:space-y-0 space-x-1 space-y-4 px-4 flex-wrap sm:items-start items-center"
                    >
                        <InertiaLink
                            :href="route('companies.index')"
                            class="flex justify-center items-center w-10 h-10 rounded-full bg-[#F4F4F4]"
                        >
                            <FontAwesomeIcon
                                size="fa-lg"
                                class="flex-shrink-0 h-5 w-5 fa-light fa-arrow-left text-[#808080]"
                            />
                        </InertiaLink>
                        <div>
                            <h1 class="font-bold text-2xl leading-8">
                                {{ company?.company_name }}
                            </h1>
                            <p class="font-medium text-[#525252] leading-6">
                                {{ company?.user?.full_name }}
                            </p>
                        </div>
                        <span
                            class="flex justify-center items-center w-[110px] h-8 rounded"
                            :class="
                                company.partnership_status === 'Validé'
                                    ? 'bg-[#4b9f0814] text-[#4B9F08]'
                                    : company.partnership_status === 'Rejeté'
                                      ? 'bg-[#f5737314] text-[#F57373]'
                                      : 'bg-[#f8950014] text-[#F89500]'
                            "
                        >
                            {{ company.partnership_status ?? "-" }}</span
                        >
                    </div>

                    <ul class="flex flex-col">
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Nom de l'entreprise :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ company?.company_name }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Promoteur :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ company?.user?.full_name }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Adresse :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ company?.address }}
                            </p>
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Téléphone :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ company?.phone_number }}
                            </p>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Email :
                            </p>
                            <p
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]"
                            >
                                {{ company?.user?.email }}
                            </p>

                            <p
                                class="font-bold text-base leading-6 sm:w-1/4 w-1/2"
                            >
                                Site Web :
                            </p>
                            <a
                                v-if="company?.website"
                                :href="company?.website"
                                target="_blank"
                                class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#28a1d1]"
                            >
                                {{ company?.website }}
                            </a>
                            <p v-else class="font-medium text-base leading-6 sm:w-1/4 w-1/2 text-[#272C2E]">-</p>

                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <div
                                class="text-base leading-6 w-full flex sm:flex-row flex-col space-x-4"
                            >
                                <p class="font-bold w-1/12">Service :</p>
                                <p v-html="formattedText(company?.service)"></p>
                            </div>
                        </li>
                        <li
                            class="bg-white even:bg-[#F6F9FD] w-full flex flex-wrap p-4"
                        >
                            <div
                                class="text-base leading-6 w-full flex sm:flex-row flex-col space-x-4"
                            >
                                <p class="font-bold w-1/12">Description :</p>
                                <p
                                    v-html="formattedText(company?.description)"
                                ></p>
                            </div>
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
        company: Object,
    },

    data() {
        return {
            warningDelete: false,
            deleteString: "",
        };
    },
    methods: {
        formattedText(text) {
            if (!text) {
                return text;
            }
            return text.replace(/\n/g, "<br>");
        },
    },
};
</script>

<style scoped>
.title {
    padding: 0px 0px 16px;
    border-bottom: 1px solid #dadee3;
}
</style>
