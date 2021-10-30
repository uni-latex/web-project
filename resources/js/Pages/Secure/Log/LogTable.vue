<template>
    <div v-if="models.data.length > 0" class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">
        <div class="overflow-auto">

            <table class="w-full">

                <thead class="bg-primary">
                    <tr class="border">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Type</th>
                        <th class="border p-2">File</th>
                        <th class="border p-2">File Date</th>
                        <th class="border p-2">Upload At</th>
                        <th class="border p-2">User</th>
                        <th class="border p-2">Status</th>
                    </tr>
                </thead>

                <tbody v-for="(model, index) in models.data" class="hover:bg-primary-50 text-left" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-100'">
                    <tr>
                        <td class="border p-2 text-center">{{ models.from + index}}</td>
                        <td class="border p-2 uppercase">{{ model.type }}</td>
                        <td class="border p-2 truncate">{{ model.original_file }}</td>
                        <td class="border p-2 truncate">{{ formatDate(model.file_date) }}</td>
                        <td class="border p-2 truncate">{{ formatDateTime(model.created_at) }}</td>
                        <td class="border p-2">{{ model.user.name }}</td>
                        <td class="border p-2">
                            <div class="flex justify-center">
                                <svg v-if="model.is_success" class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <svg v-else class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            </div>
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
                if (! date) {
                    return "-"
                }
                return moment(date).format('D MMMM Y')
            },

            formatDateTime(date) {
                return moment(date).format('D MMMM Y, h:mm:ss a')
            }
        }
    }
</script>
