<template>
    <div v-if="links.length > 3">
        <div class="flex justify-end -mb-1">
            <template v-for="link in links">
                <div v-if="link.url === null"
                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                     v-html="link.label" />
                <Link v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-primary-50 focus:border-primary"
                      :class="{ 'bg-primary': link.active }"
                      :href="link.url"
                      v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        props: {
            links: Array,
        },

        components: {
            Link,
        },
    }
</script>
