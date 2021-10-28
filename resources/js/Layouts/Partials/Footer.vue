<template>
    <div class="text-center text-sm p-6 bg-primary">
        © {{ new Date().getFullYear() }} <Link class="hover:underline" :href="route('home')">{{ $page.props.app.name }}</Link>. All Rights Reserved.
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        components: {
            Link,
        },
    }
</script>
