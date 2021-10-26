<template>
    <div>
        <Head title="Register" />

        <jet-authentication-card>
            <template #logo>
                <jet-authentication-card-logo />
            </template>

            <jet-validation-errors class="mb-4" />

            <div v-if="hasToken">
                <form @submit.prevent="submit">
                    <div v-if="showToken">
                        <jet-label for="token" value="Token" />
                        <jet-input id="token" type="text" class="mt-1 block w-full bg-gray-100" v-model="form.token" required autofocus autocomplete="token" disabled />
                    </div>

                    <div :class="showToken ? 'mt-4' : ''">
                        <jet-label for="name" value="Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                    </div>

                    <div class="mt-4">
                        <jet-label for="password" value="Password" />
                        <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="password_confirmation" value="Confirm Password" />
                        <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                        <jet-label for="terms">
                            <div class="flex items-center">
                                <jet-checkbox name="terms" id="terms" v-model="form.terms" />

                                <div class="ml-2">
                                    I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                                </div>
                            </div>
                        </jet-label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                            Already registered?
                        </Link>

                        <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Register
                        </jet-button>
                    </div>
                </form>
            </div>
            <div v-else class="flex flex-col items-center">
                {{ $page.props.app.name }} is Invite Only

                <Link :href="route('home')" class="font-bold text-blue-400 mt-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                        <span class="pl-2">Back to Home</span>
                    </div>
                </Link>
            </div>

        </jet-authentication-card>
    </div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import { Head, Link } from '@inertiajs/inertia-vue'

    export default {
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        mounted() {
            this.getInformationFromUrl
            this.hasToken
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        },

        computed: {
            showToken() {
                return this.$page.props.app.showToken
            },

            getInformationFromUrl() {
                const urlParams = new URLSearchParams(window.location.search)
                this.form.token = urlParams.get('token')
                this.form.email = urlParams.get('email')
            },

            hasToken() {
                return this.form.token
                if (this.form.token === undefined) {
                    return 'no'
                }
                return 'ok'
            },
        }
    }
</script>
