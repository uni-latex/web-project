<template>
    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            :value="value"
            @input="$emit('input', $event.target.value)"
            ref="input"
    >
        <option v-if="nullabel" :value="null">-</option>
        <option v-else :value="null" disabled>Select item</option>
        <option v-for="(name, value) in options" :value="value">{{ name}}</option>
    </select>
</template>

<script>
    export default {
        // props: [
        //     'value',
        //     'options',
        //     'disable'
        // ],

        props: {
            value: Object,

            options: Object,

            disable: {
                type: Boolean,
                default: true,
            }
        },

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        },

        computed: {
            nullabel() {
                return ! this.disable;
            }
        }
    }
</script>
