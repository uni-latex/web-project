<template>
    <div v-if="models.data.length > 0" class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">
        <div class="overflow-auto">

            <table class="w-full">

                <thead class="bg-primary">
                    <tr class="border">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Type</th>
                        <th class="border p-2">File</th>
                        <th class="border p-2">Upload At</th>
                        <th class="border p-2">User</th>
                        <th class="border p-2">Status</th>
                    </tr>
                </thead>

                <tbody v-for="(model, index) in models.data" class="hover:bg-primary-50" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-100'">
                    <tr>
                        <td class="border p-2 text-center">{{ models.from + index}}</td>
                        <td class="border p-2 uppercase text-center">{{ model.type }}</td>
                        <td class="border p-2 truncate">{{ model.original_file }}</td>
                        <td class="border p-2 truncate">{{ formatDate(model.created_at) }}</td>
                        <td class="border p-2 text-center">{{ model.user.name }}</td>
                        <td class="border p-2 flex justify-center items-start">
                            <svg v-if="model.is_success" class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <svg v-else class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <Pagination class="mt-6" :links="models.links" />
    </div>
</template>

<script>
    import Pagination from "@/Components/Pagination";

    export default {
        components: {
            Pagination,
        },

        props: [
            'models',
        ],

        methods: {
            formatDate(date) {
                return moment(date).format('D MMMM Y, h:mm:ss a')
            }
        }
    }
</script>
