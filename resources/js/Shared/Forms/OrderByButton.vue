<template>
    <button
        title="Filtrer"
        type="button"
        class="relative flex flex-col rounded-lg border border-[#718096] px-1"
        @click="toggleDropdown"
        @blur="closeDropdown"
    >
        <div
            class="w-full flex items-center justify-center space-x-2 text-[#718096] h-full"
        >
            <FontAwesomeIcon
                size="fa-lg"
                class="flex-shrink-0 h-4 w-4 fa-light fa-filter"
            />
            <span class="font-bold text-sm leading-6 truncate">{{
                customLabel
            }}</span>
        </div>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <div
                v-if="dropdownOpen"
                class="-ml-1 absolute z-50 mt-14 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm no-scrollbar"
            >
                <div
                    v-for="(element, index) in listElements"
                    :key="index"
                    class="cursor-pointer py-2 flex flex-col sm:justify-start sm:items-start sm:pl-2 justify-center items-center"
                    :class="[
                        isSelected(element)
                            ? 'text-white bg-[#007AED]'
                            : 'text-gray-900',
                    ]"
                    @click="toggleSelection(element)"
                >
                    <span
                        class="block"
                        :class="[
                            isSelected(element)
                                ? 'font-semibold'
                                : 'font-normal',
                        ]"
                    >
                        {{ element.label }}
                    </span>
                </div>
            </div>
        </transition>
    </button>
</template>

<script>
import FontAwesomeIcon from "@/Shared/Icons/FontAwesomeIcon.vue";
import isEmpty from "lodash/isEmpty";
import isEqual from "lodash/isEqual";

export default {
    components: {
        FontAwesomeIcon,
    },

    props: {
        listElements: {
            type: [Object, Array],
            default: function () {
                return [
                    { label: "Matricule", value: "matriculation_number" },
                    { label: "Nom", value: "last_name" },
                ];
            },
        },

        value: {
            type: Object,
            default: () => {
                return {};
            },
        },
    },

    emits: ["selected"],

    data() {
        return {
            selected: !isEmpty(this.value) ? this.value : {},
            dropdownOpen: false,
        };
    },

    computed: {
        customLabel() {
            return isEmpty(this.selected) ? "Filtrer" : this.selected.label;
        },
    },

    watch: {
        selected: {
            deep: true,
            handler: function (newSelected) {
                this.$emit("selected", newSelected);
            },
        },

        value(newValue) {
            this.selected = newValue;
        },
    },

    methods: {
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },

        closeDropdown() {
            this.dropdownOpen = false;
        },

        isSelected(otherObjet) {
            return isEqual(this.selected, otherObjet);
        },

        toggleSelection(element) {
            if (this.isSelected(element)) {
                this.selected = {};
            } else {
                this.selected = element;
            }
        },
    },
};
</script>
