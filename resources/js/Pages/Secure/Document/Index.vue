<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documents
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-base">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">

                    <div class="flex flex-col">

                        <!-- date range fields -->
                        <div class="flex w-full">
                            <DatePicker v-model="dateRange" is-range :attributes="datePickerAttribute" class="w-full" required>
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
                            <div class="w-full">
                                <jet-label for="transaction_type" value="Jenis Transaksi" />
                                <jet-select id="transaction_type" class="mt-1 block w-full" v-model="form.transaction_type" :options="transactionTypeOptions" required />
                            </div>

                            <div class="w-full">
                                <jet-label for="doc_type" value="Dokumen Pabean" />
                                <jet-select id="doc" class="mt-1 block w-full" v-model="form.doc_type" :options="docTypeOptions" required />
                            </div>

<!--                            <div class="w-full">-->
<!--                                <jet-label for="page" value="Per Page" />-->
<!--                                <jet-select id="page" class="mt-1 block w-full" v-model="form.per_page" :options="perPageOptions" required />-->
<!--                            </div>-->
                        </div>

                    </div>

                    <!-- buttons -->
                    <div class="flex justify-end mt-6">
                        <button @click="filterDocuments"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                            Filter
                        </button>
                        <button v-if="canDownload" @click="downloadDocuments"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                            Download
                        </button>
                    </div>

                </div>

                <DocumentTable :documents="documents" />
            </div>

        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetSelect from '@/Components/Select'
    import JetLabel from '@/Jetstream/Label'
    import DocumentTable from "@/Pages/Secure/Document/DocumentTable";
    import pickBy from 'lodash/pickBy'
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'

    export default {

        components: {
            AppLayout,
            DatePicker,
            JetLabel,
            JetInput,
            JetCheckbox,
            JetSelect,
            JetButton,
            DocumentTable,
        },

        props: {
            filters: Object,
            documents: Object,
        },

        data() {
            return {
                transactionTypeOptions: {
                    0: "Keluar",
                    1: "Masuk",
                },

                docTypeOptions: {
                    'BC2.3': 'BC2.3',
                    'BC2.5': 'BC2.5',
                    'BC2.7': 'BC2.7',
                    'BC3.0': 'BC3.0',
                    'BC4.0': 'BC4.0',
                    'BC4.1': 'BC4.1'
                },

                perPageOptions: {
                    25: 25,
                    50: 50,
                    100: 100,
                },

                dateRange: {
                    start: this.filters.start_date,
                    end: this.filters.end_date
                },

                form: {
                    transaction_type: this.filters.transaction_type,
                    doc_type: this.filters.doc_type,
                    per_page: this.filters.per_page,
                    start_date: this.filters.start_date,
                    end_date: this.filters.end_date,
                },
            }
        },

        watch: {
            dateRange() {
                this.form.start_date = this.dateRange.start
                this.form.end_date = this.dateRange.end
            }
        },

        methods: {
            filterDocuments() {
                this.formFormatDates
                this.$inertia.get(this.route('documents'), pickBy(this.form), { preserveState: true})
            },

            downloadDocuments() {
                this.formFormatDates
                const params = new URLSearchParams(this.form).toString()
                const link = document.createElement('a');
                link.href = route('documents.download') + `?${params}`
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
                return this.$page.props.user.can['downloadDocuments']
            },
        }
    }
</script>
