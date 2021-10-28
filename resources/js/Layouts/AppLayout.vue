<template>
    <div>
        <Head :title="title" />

        <jet-banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100 bg-primary">
                <!-- Primary Navigation Menu -->
                <PrimaryNavigationMenu :show="showingNavigationDropdown" @toggleNavigation="onToggleNavigation" />

                <!-- Responsive Navigation Menu -->
                <ResponsiveNavigationMenu :show="showingNavigationDropdown" @toggleNavigation="onToggleNavigation" />
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>

            <!-- Modal Portal -->
            <portal-target name="modal" multiple>
            </portal-target>
        </div>
    </div>
</template>

<script>
    import JetBanner from '@/Jetstream/Banner'
    import PrimaryNavigationMenu from "@/Layouts/Partials/PrimaryNavigationMenu";
    import ResponsiveNavigationMenu from "@/Layouts/Partials/ResponsiveNavigationMenu";
    import { Head, Link } from '@inertiajs/inertia-vue'

    export default {
        props: {
            title: String,
        },

        components: {
            Head,
            PrimaryNavigationMenu,
            ResponsiveNavigationMenu,
            JetBanner,
            Link
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            onToggleNavigation(show) {
                this.showingNavigationDropdown = show
            },
        }
    }
</script>
