<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mutations
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-base">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">

                    <div class="flex flex-col">

                        <!-- date range fields -->
                        <div class="flex w-full">
                            <DatePicker v-model="dateRange" is-range :attributes="datePickerAttribute" class="w-full" require>
                                <template v-slot="{ inputValue, inputEvents }">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-full">
                                            <jet-label for="start_date" value="Dari Tanggal" />
                                            <input
                                                class="w-full mt-1 p-2 border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:outline-none rounded-md shadow-sm"
                                                :value="formatDate(inputValue.start)"
                                                v-on="inputEvents.start"
                                            />
                                        </div>
                                        <div class="w-full">
                                            <jet-label for="end_date" value="Sampai Tanggal" />
                                            <input
                                                class="w-full mt-1 p-2 border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:outline-none rounded-md shadow-sm"
                                                :value="formatDate(inputValue.end)"
                                                v-on="inputEvents.end"
                                            />
                                        </div>
                                    </div>

                                </template>
                            </DatePicker>
                        </div>

                        <!-- document type fields -->
                        <div class="flex w-full space-x-4 items-center mt-6">
                            <div class="w-1/2">
                                <jet-label for="mutation_type" value="Jenis Mutasi" />
                                <jet-select id="mutation_type" class="mt-1 block w-full" v-model="form.mutation_type" :options="mutationTypeOptions" required autofocus />
                            </div>
                            <div class="w-1/2">
                            </div>
                        </div>

                    </div>

                    <!-- buttons -->
                    <div class="flex justify-end mt-6">
                        <button @click="filterModels"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                            Filter
                        </button>
                        <button v-if="canDownload" @click="downloadModels"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                            Download
                        </button>
                    </div>

                </div>

                <MutationTable :models="models" />

            </div>

        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSelect from '@/Components/Select'
    import JetLabel from '@/Jetstream/Label'
    import pickBy from 'lodash/pickBy'
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    import MutationTable from "@/Pages/Secure/Mutation/MutationTable";

    export default {
        components: {
            AppLayout,
            JetLabel,
            JetSelect,
            DatePicker,
            MutationTable,
        },

        props: {
            filters: Object,
            models: Object,
        },

        data() {
            return {
                mutationTypeOptions: {
                    bbp: "Bahan Baku dan Bahan Penolong",
                    bdp: "Posisi Barang dalam Proses ( WIP )",
                    bj: "Barang Jadi",
                    bs: "Barang Sparepart",
                    bsds: "Barang Sisa dan Scrap",
                    mdpk: "Mesin dan Peralatan Kantor",
                },

                dateRange: {
                    start: this.filters.start_date,
                    end: this.filters.end_date
                },

                form: {
                    start_date: this.filters.start_date,
                    end_date: this.filters.end_date,
                    mutation_type: this.filters.mutation_type,
                }
            }
        },

        methods: {
            filterModels() {
                this.formFormatDates
                this.$inertia.get(route('mutations'), pickBy(this.form), { preserveState: true})
            },

            downloadModels() {
                this.formFormatDates
                const params = new URLSearchParams(this.form).toString()
                const link = document.createElement('a');
                link.href = route('mutations.download') + `?${params}`
                document.body.appendChild(link);
                link.click();
            },

            formatDate(inputValue) {
                return moment(inputValue, "MM/DD/YYYY").format('DD MMMM Y')
            },
        },

        computed: {
            datePickerAttribute() {
                return [
                    {
                        key: 'today',
                        dot: 'red',
                        dates: new Date(),
                    }
                ]
            },

            formFormatDates() {
                this.form.start_date = moment(this.form.start_date).format('Y-MM-DD')
                this.form.end_date = moment(this.form.end_date).format('Y-MM-DD')
            },

            canDownload() {
                return this.$page.props.user.can['downloadMutations']
            },
        }
    }
</script>
