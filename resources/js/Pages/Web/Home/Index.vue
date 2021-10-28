<template>
    <div>
        <Head title="Home" />

        <WebLayout>
            <div class="flex w-full items-center justify-center">
                <span class="text-2xl">Welcome to {{ $page.props.app.name }}</span>
            </div>
        </WebLayout>
    </div>
</template>

<script>
    import { Head } from '@inertiajs/inertia-vue'
    import WebLayout from "@/Layouts/WebLayout"

    export default {
        components: {
            Head,
            WebLayout
        }
    }
</script>
