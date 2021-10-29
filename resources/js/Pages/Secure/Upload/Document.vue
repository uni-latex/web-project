<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">

        <div class="text-2xl tracking-widest uppercase">Document</div>

        <form @submit.prevent="uploadDocument" class="mt-6">

            <div class="flex flex-col">
                <div class="flex items-center">
                    <jet-label for="document_file" value="Berkas" />
                    <div class="ml-4 text-red-400">{{ $page.props.errors['document_file'] }}</div>
                </div>
                <input id="document_file"
                           type="file"
                           class="mt-1 block w-full focus:outline-none"
                           accept=".csv,.xls,.xlsx"
                           @input="form.document_file = $event.target.files[0]" required />
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
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetButton from '@/Jetstream/Button'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetLabel,
            JetInput,
            JetButton,
            JetValidationErrors,
        },

        data() {
            return {
                form: this.$inertia.form({
                    type: 'document',
                    document_file: null,
                })
            }
        },

        methods: {
            uploadDocument() {
                this.form.post(route('uploads'), {
                    onFinish: () => this.form.reset('file')
                })
            },
        },
    }
</script>
