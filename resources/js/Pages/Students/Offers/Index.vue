<template>
    <div class="max-w-screen-xl mx-auto sm:py-8 py-4 px-2">
        <h1 class="font-bold sm:text-2xl text-base leading-8">
            Les Offres des stages en cours vous concernant
        </h1>
        <div class="my-4">
            <SearchRecordsInput v-model="form.search" class="relative w-full" />
        </div>

        <section
            v-for="offer in offers.data"
            :key="offer.id"
            class="just-about-us w-full md:my-[60px] my-[18px]"
        >
            <div
                class="max-w-screen-xl mx-auto text-white space-y-[30px] pt-4 py-0 pb-0 md:pt-4 md:py-0 md:pb-0 flex flex-col items-center"
                data-aos="fade-up"
                data-aos-duration="3000"
            >
                <p
                    class="text-center text-[#212121] text-base font-bold uppercase"
                >
                    Campagne de stage : {{ offer?.intern_ship?.title ?? "-" }}
                </p>
                <FileManager
                    v-if="offer?.fileData && offer?.fileData?.length !== 0"
                    class="w-full"
                    :attached-files="offer?.fileData ?? []"
                    label-idle=""
                    :allow-multiple="false"
                    :allow-image-prewiew="true"
                    :disabled="true"
                />

                <img
                    v-else
                    src="@/Assets/images/ifri_huawe.png"
                    class="md:w-auto md:h-[666px] w-[265px] h-[180px]"
                    alt=""
                />
                <div
                    class="w-full theLast text-white flex flex-col space-y-[13px] mx-auto xl:pl-[11.5%] xl:pr-[24px] pl-[13px] pr-[13px] md:justify-start justify-center md:items-start items-center py-[32px]"
                >
                    <p
                        class="font-semibold text-[#212121] text-[24px] md:text-[40px] uppercase p-0"
                    >
                        {{ offer?.title }}
                    </p>
                    <p class="text-[#212121] p-0 text-xl">
                        <span class="font-bold"
                        >Entreprise: </span> {{ offer?.company?.company_name }}

                    </p>

                    <p
                        v-html="formattedText(offer?.description)"
                        class="text-black w-full leading-[24px] text-sm md:text-base md:text-start text-center"
                    ></p>
                    <p
                        v-html="formattedText(offer?.requirements)"
                        class="text-black w-full leading-[24px] text-sm md:text-base md:text-start text-center"
                    ></p>
                    <p
                        v-html="formattedText(offer?.responsibilities)"
                        class="text-black w-full leading-[24px] text-sm md:text-base md:text-start text-center"
                    ></p>
                    <a
                        href="https://www.iziimo.com/"
                        target="_blank"
                        class="w-[150px] text-sm bg-blue-700 rounded md:bg-transparent text-[#EDEDEF] md:p-0 btn-link font-normal"
                        aria-current="page"
                        >Postuler</a
                    >
                </div>
            </div>
        </section>

        <div v-if="offers.data.length === 0">Aucune offre trouvée !.</div>

        <Pagination class="justify-end mb-4" :links="offers.links" />

    </div>
</template>

<script>
import StudentLayout from "@/Layouts/StudentLayout.vue";
import SearchRecordsInput from "@/Shared/Forms/SearchRecordsInput.vue";
import { throttle, pickBy } from "lodash";
import FileManager from "@/Shared/FileManager.vue";
import { defineAsyncComponent } from "vue";

const Pagination = defineAsyncComponent({
    loader: () => import("@/Shared/Pagination.vue"),
});

export default {
    components: {
        SearchRecordsInput,
        Pagination,
        FileManager,
    },

    layout: StudentLayout,

    props: {
        filters: Object,
        offers: {
            type: Object,
            default() {
                return {};
            },
        },
    },

    data() {
        return {
            form: {
                search: this.filters.search,
            },
        };
    },

    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get(
                    "get-offers-for-students",
                    pickBy(this.form),
                    {
                        preserveState: true,
                    },
                );
            }, 150),
        },
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
.just-about-us > div {
    background: #f1f0ef;
    border-radius: 16px 16px 0px 0px;
}
.theLast {
    background: white;
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.btn-link {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    padding: 12px 12px;
    height: 40px;
    background: #007aed;
    border-radius: 50px;
}
@media screen and (max-width: 320px) {
    img {
        max-width: 100%;
        height: auto;
    }
}
</style>
