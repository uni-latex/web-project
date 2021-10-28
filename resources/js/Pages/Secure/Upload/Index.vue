<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Upload
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-base">

                <div v-if="$page.props.flash.success" class="mb-6">
                    <div class="bg-green-200 border p-2 rounded-md border border-green-400">{{ $page.props.flash.success }}</div>
                </div>
                <div v-else-if="$page.props.flash.error" class="mb-6">
                    <div class="bg-red-200 border p-2 rounded-md border border-red-400">{{ $page.props.flash.error }}</div>
                </div>

                <Document v-if="$page.props.user.can['uploadDocument']" />

                <Mutation v-if="$page.props.user.can['uploadMutation']" />

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
        }
    }
</script>
