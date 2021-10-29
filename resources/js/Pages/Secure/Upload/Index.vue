<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Upload
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-base">

                <div v-if="$page.props.flash.success" class="mb-4">
                    <div class="bg-green-200 border p-2 rounded-md border border-green-400">{{ $page.props.flash.success }}</div>
                </div>
                <div v-else-if="$page.props.flash.error" class="mb-4">
                    <div class="bg-red-200 border p-2 rounded-md border border-red-400">{{ $page.props.flash.error }}</div>
                </div>

                <div class="flex flex-col md:flex-row justify-between w-full items-start md:space-x-4">

                    <Document class="w-full md:w-1/2" v-if="$page.props.user.can['uploadDocument']" />

                    <Mutation class="w-full md:w-1/2 mt-4 md:mt-0" v-if="$page.props.user.can['uploadMutation']" />

                </div>

            </div>

        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Document from '@/Pages/Secure/Upload/Document'
    import Mutation from '@/Pages/Secure/Upload/Mutation'

    export default {
        components: {
            AppLayout,
            Document,
            Mutation,
        },

        computed: {
            padLeft() {
                if (this.$page.props.user.can['uploadDocument']) {
                    return 'pl-2'
                }
            },

            padRight() {
                if (this.$page.props.user.can['uploadMutation']) {
                    return 'pr-2'
                }
            }
        },
    }
</script>
