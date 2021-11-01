<template>
    <Link :href="route('home')">
        <img class="h-20" :src="$page.props.app.logo" />
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        components: {
            Link,
        },
    }
</script>
