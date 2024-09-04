<template>
    <div id="default-layout">
        <div class="color-content flex justify-center items-center md:p-0 p-4">
            <div
                id="start-login"
                class="relative flex flex-col md:p-10 p-6 rounded-2xl bg-[#fff] sm:w-[500px] w-auto"
            >
                <div
                    class="relative flex flex-col space-y-6 justify-center items-center"
                >
                    <div
                        class="flex flex-col md:space-y-4 space-y-2 justify-center items-center"
                    >
                        <AuthentificationLogo />
                        <div class="flex flex-col space-y-2 text-[#292929]">
                            <p
                                class="font-bold md:text-2xl text-xl text-center tracking-[-0.48px]"
                            >
                                Connexion
                            </p>
                            <p
                                class="text-base text-center font-medium tracking-[0.32px] px-2"
                            >
                                Veuillez vous connecter en renseignant votre
                                adresse gmail et votre mot de passe
                            </p>
                        </div>
                    </div>
                    <!-- Form to login -->
                    <form
                        @submit.prevent="submit"
                        class="flex flex-col md:space-y-6 space-y-4 items-start justify-start w-full"
                    >
                        <!-- Email -->
                        <div class="flex flex-col space-y-2 w-full">
                            <InputLabel for="email" value="Email" />
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

                        <div class="w-full">
                            <div
                                class="flex flex-col space-y-2 w-full relative"
                            >
                                <InputLabel for="password" value="Mot de passe">
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

                            <p class="text-end">
                                <InertiaLink
                                    :href="route('password.request')"
                                    class="text-sm text-[#0047FF] font-bold leading-[140%] underline opacity-80"
                                    >Mot de passe oublié ?</InertiaLink
                                >
                            </p>
                        </div>

                        <PrimaryButton
                            :disabled="form.processing"
                            :loading="form.processing"
                        >
                            <span class="text-base text-white font-bold"
                                >Se connecter</span
                            >
                        </PrimaryButton>
                    </form>
                </div>
                <p class="text-start pt-2">
                        <InertiaLink
                            :href="route('company-register-view')"
                            class="text-sm text-[#0047FF] font-semibold underline opacity-80"
                            >Vous êtes une nouvelle entreprise ? Enregistrez-vous ici.</InertiaLink
                        >
                    </p>
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

export default {
    components: {
        PasswordIcon,
        AuthentificationLogo,
        InputError,
        TextInput,
        PrimaryButton,
        InputLabel,
        InertiaLink,
    },

    data() {
        return {
            form: useForm({
                email: "",
                password: "",
                remember: false,
            }),
        };
    },
    methods: {
        submit() {
            this.form
                .transform((data) => ({
                    ...data,
                    remember: this.form.remember ? "on" : "",
                }))
                .post(route("login"), {
                    onFinish: () => this.form.reset("password"),
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
    min-height: 100vh;
}
.color-content {
    position: relative;
    width: 100%;
    min-height: 100vh;
    background: rgba(5, 104, 197, 0.92);
}
</style>
