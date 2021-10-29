<template>
    <AppLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mutations
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

                        <div class="flex flex-col w-full mt-2 md:mt-0">
                            <jet-label for="mutation_type" value="Jenis Mutasi" />
                            <jet-select id="mutation_type" class="mt-1 block w-full" v-model="form.mutation_type" :options="fields.mutation_types" required />
                        </div>

                    </div>

                    <div class="flex flex-col md:flex-row md:space-x-4 mt-2 md:mt-4">

                        <div class="flex flex-col w-full">
                            <jet-label for="goods_code" value="Kode Barang" />
                            <div class="flex items-center">
                                <jet-input type="text" class="mt-1 block w-full" v-model="form.goods_code" />
                                <button  v-if="form.goods_code" class="ml-2 text-xs uppercase" @click="resetGoodsCode">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col w-full mt-2 md:mt-0">
                            <jet-label for="goods_name" value="Nama Barang" />
                            <div class="flex items-center">
                                <jet-input type="text" class="mt-1 block w-full" v-model="form.goods_name" />
                                <button  v-if="form.goods_name" class="ml-2 text-xs uppercase" @click="resetGoodsName">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <MutationTable :models="models" @on-download="onClickDownload" />

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
    import MutationTable from "@/Pages/Secure/Mutation/MutationTable"
    import pickBy from 'lodash/pickBy'
    import throttle from 'lodash/throttle'

    export default {
        components: {
            AppLayout,
            DatePicker,
            JetLabel,
            JetInput,
            JetSelect,
            MutationTable,
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
                    mutation_type: this.filters.mutation_type,
                    start_date: this.filters.start_date,
                    end_date: this.filters.end_date,
                    goods_code: this.filters.goods_code,
                    goods_name: this.filters.goods_name,
                }
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
                        route('mutations'),
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
                link.href = route('mutations.download') + `?${params}`
                document.body.appendChild(link);
                link.click();
            },

            resetGoodsName() {
                this.form.goods_name = ''
            },

            resetGoodsCode() {
                this.form.goods_code = ''
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
