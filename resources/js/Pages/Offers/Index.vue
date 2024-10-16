<template>
    <div
        v-if="
            $page.props.auth.user.role === 'Company' &&
            $page.props.auth.user.profile?.partnership_status !== 'Validé'
        "
        class="w-full flex my-8 justify-center items-center"
    >
        <div
            class="xl:w-[913px] w-[87%] xl:px-2 px-3 flex space-x-[8px] bg-[#F9FBFF] xl:rounded-[32px] rounded-[100px] border border-red-500 xl:h-[66px] h-[68px] xl:py-1 py-2 items-center justify-center"
        >
            <span
                v-if="
                    $page.props.auth.user.profile?.partnership_status ===
                    'Nouveau'
                "
                class="font-semibold sm:text-[24px] text-[13px] text-red-400"
                >Veuillez attendre ! Vous êtes en attente de validation...</span
            >
            <span
                v-if="
                    $page.props.auth.user.profile?.partnership_status ===
                    'Rejeté'
                "
                class="font-semibold sm:text-[24px] text-[13px] text-red-400"
                >Compte réjeté ! Votre entreprise ne répond pas aux normes
                d'IFRI</span
            >
        </div>
    </div>

    <div v-else class="px-4 py-4 sm:px-6 md:px-8 md:py-8">
        <div class="flex flex-col bg-[#FFFFFF] p-4 rounded-lg">
            <div class="py-2 align-middle inline-block w-full">
                <div
                    class="mb-4 flex flex-row content items-center justify-between"
                >
                    <div
                        class="flex sm:flex-row flex-col sm:space-x-4 sm:space-y-0 space-x-0 space-y-4 w-full"
                    >
                        <SearchRecordsInput
                            v-model="form.search"
                            class="relative"
                            :class="
                                $page.props.auth.user.role === 'Institute'
                                    ? 'w-full'
                                    : 'sm:w-10/12 w-full'
                            "
                        />
                        <div
                            v-if="$page.props.auth.user.role === 'Company'"
                            class="flex sm:flex-row flex-col sm:space-x-4 sm:space-y-0 space-x-0 space-y-4 sm:w-2/12 w-full"
                        >
                            <InertiaLink
                                class="inline-flex items-center justify-center w-full py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#007AED] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :href="route('offers.create')"
                            >
                                <FontAwesomeIcon
                                    size="fa-lg"
                                    class="flex-shrink-0 h-4 w-4 fa-light fa-plus"
                                />

                                <span class="pl-3">Nouveau</span>
                            </InertiaLink>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto max-h-[60vh] no-scrollbar">
                <table class="min-w-full table-fixed divide-y divide-gray-300">
                    <TableHead
                        :header="tableHeader"
                        :has-actions="$page.props.auth.user.role === 'Company'"
                        class="sticky top-0 bg-[#FFFFFF] z-40"
                    />
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="offer in offers.data"
                            :key="offer.id"
                            class="bg-white even:bg-gray-50"
                        >
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ offer?.title }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ truncateText(offer?.description) ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ truncateText(offer?.requirements) ?? "-" }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{
                                    truncateText(offer?.responsibilities) ?? "-"
                                }}
                            </td>
                            <td
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ offer?.intern_ship?.title ?? "-" }}
                            </td>

                            <td
                                v-if="
                                    $page.props.auth.user.role === 'Institute'
                                "
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium"
                            >
                                {{ offer?.company?.company_name ?? "-" }}
                            </td>

                            <td
                                v-else
                                class="px-2 py-4 whitespace-nowrap text-sm text-left font-medium cursor-pointer"
                            >
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
                                        <ul
                                            class="divide-y divide-gray-300 z-50 relative"
                                        >
                                            <li class="w-full p-2">
                                                <InertiaLink
                                                    :href="
                                                        route(
                                                            'offers.show',
                                                            offer.id,
                                                        )
                                                    "
                                                    class="text-sm font-semibold text-[#268FF2]"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-eye"
                                                    />
                                                    <span class="pl-2"
                                                        >Voir détails</span
                                                    >
                                                </InertiaLink>
                                            </li>
                                            <li class="w-full p-2">
                                                <InertiaLink
                                                    :href="
                                                        route(
                                                            `offers.edit`,
                                                            offer.id,
                                                        )
                                                    "
                                                    class="text-sm font-semibold text-[#268FF2]"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-pencil"
                                                    />
                                                    <span class="pl-2"
                                                        >Mettre à jour</span
                                                    >
                                                </InertiaLink>
                                            </li>
                                            <li class="w-full p-2">
                                                <InertiaLink
                                                    :title="'Créer de nouvelle offre à base de ce stage'"
                                                    :href="
                                                        route(
                                                            `offers.edit`,
                                                            offer.id,
                                                        )
                                                    "
                                                    class="text-sm font-semibold text-[#268FF2]"
                                                >
                                                    <FontAwesomeIcon
                                                        size="fa-lg"
                                                        class="flex-shrink-0 h-4 w-4 fa-light fa-plus"
                                                    />
                                                    <span class="pl-2"
                                                        >Voir les
                                                        candidatures</span
                                                    >
                                                </InertiaLink>
                                            </li>
                                        </ul>
                                    </template>
                                </Dropdown>
                            </td>
                        </tr>
                        <tr v-if="offers.data.length === 0">
                            <td
                                class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium"
                                colspan="8"
                            >
                                Aucune offre trouvée.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br />
            <Pagination class="justify-end" :links="offers.links" />
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchRecordsInput from "@/Shared/Forms/SearchRecordsInput.vue";
import ExportButton from "@/Shared/Forms/ExportButton.vue";
import useStringUtilities from "@/Composables/stringUtilities.js";
import TableHead from "@/Shared/Tables/TableHead.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { Link as InertiaLink } from "@inertiajs/vue3";
import { defineAsyncComponent } from "vue";
import { throttle, pickBy } from "lodash";

const FontAwesomeIcon = defineAsyncComponent({
    loader: () => import("@/Shared/Icons/FontAwesomeIcon.vue"),
});

const Pagination = defineAsyncComponent({
    loader: () => import("@/Shared/Pagination.vue"),
});

export default {
    components: {
        AppLayout,
        FontAwesomeIcon,
        SearchRecordsInput,
        ExportButton,
        TableHead,
        Pagination,
        Dropdown,
        InertiaLink,
        ExportButton,
    },

    layout: AppLayout,

    props: {
        filters: Object,
        offers: {
            type: Object,
            default() {
                return {};
            },
        },
    },

    setup() {
        const { truncateText } = useStringUtilities();

        return { truncateText };
    },

    data() {
        return {
            form: {
                search: this.filters.search,
            },

            tableHeader: [
                "Titre",
                "Description",
                "Exigences",
                "Responsabilités",
                "Stage",
            ],
        };
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/offers", pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
        },
    },

    mounted() {
        if (this.$page.props.auth.user.role === "Institute") {
            this.tableHeader.push("Entreprise");
        }
    },
};
</script>
