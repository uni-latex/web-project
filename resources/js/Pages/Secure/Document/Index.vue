<template>
    <AppLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documents
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-base">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">

                    <div class="flex flex-col md:flex-row md:space-x-4">

                        <!-- date range fields -->
                        <div class="flex w-full">
                            <DatePicker is-range :columns="2" v-model="dateRange" :attributes="datePickerAttribute" class="w-full">
                                <template v-slot="{ inputValue, togglePopover }">
                                    <jet-label for="tanggal" value="Tanggal" />
                                    <input class="mt-1 p-2.5 text-center w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:outline-none rounded-md shadow-sm"
                                           :value="`${inputValue.start} - ${inputValue.end}`"
                                           @click="togglePopover" />
                                </template>
                            </DatePicker>
                        </div>

                        <!-- transaksi fields -->
                        <div class="flex flex-col w-full mt-2 md:mt-0">
                            <jet-label for="transaction_type" value="Transaksi" />
                            <jet-select id="transaction_type" class="mt-1 block w-full" v-model="form.transaction_type" :options="fields.transaction_types" required />
                        </div>

                        <!-- dokumen fields -->
                        <div class="flex flex-col w-full mt-2 md:mt-0">
                            <jet-label for="document_type" value="Dokumen" />
                            <jet-select id="document_type" class="mt-1 block w-full" v-model="form.doc_type" :options="fields.document_types" required />
                        </div>

                    </div>

                    <div class="flex flex-col md:flex-row md:space-x-4 mt-2 md:mt-4">

                        <div class="flex flex-col w-full">
                            <jet-label value="Kode Barang" />
                            <div class="flex items-center">
                                <jet-input type="text" class="mt-1 block w-full" v-model="form.goods_code" />
                                <button  v-if="form.goods_code" class="ml-2 text-xs uppercase" @click="resetGoodsCode">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col w-full mt-2 md:mt-0">
                            <jet-label value="Nama Barang" />
                            <div class="flex items-center">
                                <jet-input type="text" class="mt-1 block w-full" v-model="form.goods_name" />
                                <button  v-if="form.goods_name" class="ml-2 text-xs uppercase" @click="resetGoodsName">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col w-full mt-2 md:mt-0">
                            <jet-label value="Vendor" />
                            <div class="flex items-center">
                                <jet-input type="text" class="mt-1 block w-full" v-model="form.vendor" />
                                <button  v-if="form.vendor" class="ml-2 text-xs uppercase" @click="resetVendor">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <DocumentTable :documents="models" :transaction="form.transaction_type" @on-download="onClickDownload" />

            </div>

        </div>

    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetSelect from '@/Components/Select'
    import DocumentTable from "@/Pages/Secure/Document/DocumentTable";
    import pickBy from 'lodash/pickBy'
    import throttle from "lodash/throttle";

    export default {
        components: {
            AppLayout,
            DatePicker,
            JetLabel,
            JetInput,
            JetSelect,
            DocumentTable
        },

        props: {
            fields: Object,
            filters: Object,
            models: Object,
        },

        data() {
            return {
                dateRange: {
                    start: this.filters.start_date,
                    end: this.filters.end_date,
                },

                form: {
                    transaction_type: this.filters.transaction_type,
                    doc_type: this.filters.doc_type,
                    start_date: this.filters.start_date,
                    end_date: this.filters.end_date,
                    goods_code: this.filters.goods_code,
                    goods_name: this.filters.goods_name,
                    vendor: this.filters.vendor,
                },
            }
        },

        watch: {
            dateRange() {
                this.form.start_date = this.formatDate(this.dateRange.start)
                this.form.end_date = this.formatDate(this.dateRange.end)
            },

            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get(
                        route('documents'),
                        pickBy(this.form),
                        {
                            preserveState: true,
                        }
                    )
                }, 150),
            }
        },

        methods: {
            formatDate(date) {
                return moment(date).format('Y-MM-DD')
            },

            onClickDownload() {
                const params = new URLSearchParams(this.form).toString()
                const link = document.createElement('a');
                link.href = route('documents.download') + `?${params}`
                document.body.appendChild(link);
                link.click();
            },

            resetGoodsName() {
                this.form.goods_name = ''
            },

            resetGoodsCode() {
                this.form.goods_code = ''
            },

            resetVendor() {
                this.form.vendor = ''
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
        },
    }
</script>
