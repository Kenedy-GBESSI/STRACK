<template>
    <div id="default-layout" class="overflow-hidden">
        <div class="color-content flex justify-center items-center md:p-0 p-4 overflow-hidden no-scrollbar">
            <div
                id="start-login"
                class="relative flex flex-col md:px-10 md:py-5 p-3 rounded-2xl bg-[#fff] sm:w-1/2 w-auto overflow-hidden no-scrollbar"
            >
                <div
                    class="relative flex flex-col space-y-6 justify-center items-center overflow-hidden no-scrollbar"
                >
                    <div
                        class="flex flex-col md:space-y-4 space-y-2 justify-center items-center"
                    >
                        <AuthentificationLogo />
                        <div class="flex flex-col space-y-2 text-[#292929]">
                            <p
                                class="font-bold md:text-2xl text-xl text-center tracking-[-0.48px]"
                            >
                                Enregistrement entreprise
                            </p>
                            <p
                                class="text-base text-center font-medium tracking-[0.32px] px-2"
                            >
                                Veuillez vous enregistrer en renseignant vos
                                informations
                            </p>
                        </div>
                    </div>
                    <!-- Form to login -->
                    <form
                        @submit.prevent="submit"
                        class="flex flex-wrap w-full overflow-hidden no-scrollbar"
                    >
                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="company_name" value="Nom de l'entreprise *" />
                            <TextInput
                                id="company_name"
                                v-model="form.company_name"
                                name="company_name"
                                type="company_name"
                                placeholder="Ex: DeafSync"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.company_name"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="last_name" value="Nom du promoteur *" />
                            <TextInput
                                id="last_name"
                                v-model="form.last_name"
                                name="last_name"
                                type="last_name"
                                placeholder="Ex: GBESSI"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.last_name"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="first_name" value="Prénom du promoteur *" />
                            <TextInput
                                id="first_name"
                                v-model="form.first_name"
                                name="first_name"
                                type="first_name"
                                placeholder="Ex: Kénédy"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.first_name"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="email" value="Email *" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                name="email"
                                type="email"
                                placeholder="Ex: email@gmail.com"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="phone_number" value="Téléphone *" />
                            <TextInput
                                id="phone_number"
                                v-model="form.phone_number"
                                name="phone_number"
                                type="phone_number"
                                placeholder="Ex: 94246578"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.phone_number"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="website" value="Site web" />
                            <TextInput
                                id="website"
                                v-model="form.website"
                                name="website"
                                type="url"
                                placeholder="Ex: https://fidem-impact.com"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.website"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="address" value="Addresse *" />
                            <TextInput
                                id="address"
                                v-model="form.address"
                                name="address"
                                type="address"
                                placeholder="Ex: Cotonou, Toyota, Rue 4"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.address"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="password" value="Mot de passe *">
                                <PasswordIcon />
                            </InputLabel>
                            <TextInput
                                id="password"
                                v-model="form.password"
                                name="password"
                                type="password"
                                placeholder="..............."
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.password"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="password_confirmation" value="Confirmation de mot de passe *">
                                <PasswordIcon />
                            </InputLabel>
                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                name="password_confirmation"
                                type="password"
                                placeholder="..............."
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.password_confirmation"
                            />
                        </div>

                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="service" value="Service" />
                            <Textarea
                                id="service"
                                v-model="form.service"
                                name="service"
                                placeholder="Ex: Nous faisons du développement web"
                            >

                            </Textarea>
                            <InputError
                                class="mt-2"
                                :message="form.errors.service"
                            />
                        </div>
                        <div
                            class="flex flex-col space-y-2 sm:w-1/2 w-full sm:pr-6 pr-0 mb-4"
                        >
                            <InputLabel for="description" value="Description" />
                            <Textarea
                                id="description"
                                v-model="form.description"
                                name="description"
                                placeholder="Ex: Nous sommes ..."
                            >

                            </Textarea>
                            <InputError
                                class="mt-2"
                                :message="form.errors.description"
                            />
                        </div>

                        <PrimaryButton
                            :disabled="form.processing"
                            :loading="form.processing"
                        >
                            <span class="text-base text-white font-bold"
                                >S'en registrer</span
                            >
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AuthentificationLogo from "@/Components/icons/AuthentificationLogo.vue";
import PasswordIcon from "@/Components/icons/PasswordIcon.vue";
import { Link as InertiaLink, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Textarea from "@/Components/Textarea.vue";

export default {
    components: {
        PasswordIcon,
        AuthentificationLogo,
        InputError,
        TextInput,
        PrimaryButton,
        InputLabel,
        InertiaLink,
        Textarea,
    },

    data() {
        return {
            form: useForm({
                company_name: "",
                last_name: "",
                first_name: "",
                phone_number: "",
                website: "",
                address: "",
                email: "",
                password: "",
                password_confirmation: "",
                service: "",
                description: "",
            }),
        };
    },
    methods: {
        submit() {
            this.form
                .post(route("company-register"), {
                    onFinish: () => this.form.reset("password", "password_confirmation"),
                });
        },
    },
};
</script>

<style scoped>
#default-layout {
    position: relative;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: "Nunito", sans-serif !important;
    font-weight: normal !important;
    width: 100vw;
    background-image: url("@/Assets/images/ifri_huawe.png");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    min-height: auto;
    overflow: hidden;
}
.color-content {
    position: relative;
    width: 100%;
    min-height: 100vh;
    background: rgba(5, 104, 197, 0.92);
    overflow: hidden;
}
</style>
