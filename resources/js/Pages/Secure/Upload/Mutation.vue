<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">

        <div class="text-2xl tracking-widest uppercase">Mutation</div>

        <form @submit.prevent="uploadMutation" class="mt-6">

            <!-- date range fields -->
            <div class="flex w-full">
                <DatePicker v-model="form.mutation_date" :attributes="datePickerAttribute" class="w-full" required>
                    <template v-slot="{ inputValue, togglePopover }">
                        <jet-label for="start_date" value="Tanggal" />
                        <input
                            class="w-full mt-1 p-2.5 border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:outline-none rounded-md shadow-sm"
                            :value="inputValue"
                            @click="togglePopover" />
                    </template>
                </DatePicker>
            </div>

            <div class="mt-4">
                <jet-label for="mutation_type" value="Jenis Mutasi" />
                <jet-select id="mutation_type" class="mt-1 block w-full" v-model="form.mutation_type" :options="$page.props.fields.mutation_types" required />
            </div>

            <div class="flex flex-col mt-4">
                <div class="flex items-center">
                    <jet-label for="document_file" value="Berkas" />
                    <div class="ml-4 text-red-400">{{ $page.props.errors['mutation_file'] }}</div>
                </div>
                <input id="document_file"
                       type="file"
                       class="mt-1 block w-full focus:outline-none"
                       accept=".csv,.xls,.xlsx"
                       @input="form.mutation_file = $event.target.files[0]" required />
            </div>

            <progress class="w-full" v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>

            <div class="flex justify-end mt-6">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Upload
                </jet-button>
            </div>
        </form>

    </div>
</template>

<script>
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    import JetLabel from '@/Jetstream/Label'
    import JetButton from '@/Jetstream/Button'
    import JetSelect from '@/Components/Select'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            DatePicker,
            JetLabel,
            JetButton,
            JetSelect,
            JetValidationErrors,
        },

        data() {
            return {
                form: this.$inertia.form({
                    type: 'mutation',
                    mutation_date: new Date(),
                    mutation_type: Object.keys(this.$page.props.fields.mutation_types)[0],
                    mutation_file: null,
                })
            }
        },

        methods: {
            uploadMutation() {
                this.form.post(route('upload'), {
                    onFinish: () => this.form.reset()
                })
            },
        },

        computed: {
            datePickerAttribute() {
                return [
                    {
                        key: 'today',
                        dot: 'red',
                    }
                ]
            },
        },
    }
</script>
