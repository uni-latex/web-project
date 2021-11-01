<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Logs
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-base">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">

                    <div class="flex flex-col md:flex-row md:space-x-4">

                        <!-- type fields -->
                        <div class="flex flex-col w-full mt-2 md:mt-0">
                            <jet-label value="Upload Type" />
                            <jet-select id="upload_type" class="mt-1 block w-full" v-model="form.upload_type" :options="fields.upload_types" :disable="false" required />
                        </div>

                    </div>

                </div>

                <LogTable :models="models" />

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
    import pickBy from 'lodash/pickBy'
    import throttle from "lodash/throttle";
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    import LogTable from "@/Pages/Secure/Log/LogTable";

    export default {

        components: {
            AppLayout,
            DatePicker,
            JetLabel,
            JetInput,
            JetCheckbox,
            JetSelect,
            JetButton,
            LogTable,
        },

        props: {
            fields: Object,
            filters: Object,
            models: Object,
        },

        data() {
            return {
                form: {
                    upload_type: this.filters.upload_type
                }
            }
        },

        watch: {
            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get(
                        route('logs'),
                        pickBy(this.form),
                        {
                            preserveState: true,
                        }
                    )
                }, 150)
            }
        },

        methods: {
            // filterDocuments() {
            //     this.formFormatDates
            //     this.$inertia.get(this.route('documents'), pickBy(this.form), { preserveState: true})
            // },
            //
            // downloadDocuments() {
            //     this.formFormatDates
            //     const params = new URLSearchParams(this.form).toString()
            //     const link = document.createElement('a');
            //     link.href = route('documents.download') + `?${params}`
            //     document.body.appendChild(link);
            //     link.click();
            // },
            //
            // formatDate(inputValue) {
            //     return moment(inputValue, "MM/DD/YYYY").format('DD MMMM Y')
            // },
        },

        computed: {
            // datePickerAttribute() {
            //     return [
            //         {
            //             key: 'today',
            //             dot: 'red',
            //             dates: new Date(),
            //         }
            //     ]
            // },
            //
            // formFormatDates() {
            //     this.form.start_date = moment(this.form.start_date).format('Y-MM-DD')
            //     this.form.end_date = moment(this.form.end_date).format('Y-MM-DD')
            // },
            //
            // canDownload() {
            //     return this.$page.props.user.can['downloadDocuments']
            // },
        }
    }
</script>
