<template>
    <div class="flex flex-col min-h-screen">
        <Head :title="title" />

        <!-- Page Header -->
        <div class="w-full bg-primary">
            <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8">
                <div class="h-16 flex items-center justify-between">
                    <Link :href="route('home')" class="flex items-center">
                        <img class="h-12" :src="$page.props.app.logo" />
                        <span class="hidden md:block ml-4 uppercase tracking-widest text-2xl">{{ $page.props.app.name }}</span>
                    </Link>
                    <div class="flex items-center space-x-4">

<!--                        <Link :href="route('home')" class="bg-white px-3 py-2 rounded-md  hover:text-gray-700">Home</Link>-->

                        <template v-if="$page.props.user">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ $page.props.user.name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                                </template>

                                <template #content>

                                    <jet-dropdown-link :href="route('dashboard')" as="a">
                                        Dashboard
                                    </jet-dropdown-link>

                                    <jet-dropdown-link v-if="$page.props.user.can['viewNova']" href="/nova/dashboards/main" as="a">
                                        Admin
                                    </jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button" >
                                            Log Out
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </template>
                        <template v-else>
                            <Link :href="route('login')" class="hover:text-gray-700">
                                Log in
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="flex flex-grow">
            <slot></slot>
        </main>

        <!-- Page Footer -->
        <Footer />
    </div>
</template>

<script>
    import Footer from '@/Layouts/Partials/Footer'
    import { Link } from '@inertiajs/inertia-vue'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'

    export default {
        props: {
            title: String,
        },

        components: {
            Link,
            JetDropdown,
            JetDropdownLink,
            Footer,
        },

        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        },
    }
</script>

<style scoped>

</style>
