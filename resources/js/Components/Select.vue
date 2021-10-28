<template>
    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            :value="value"
            @input="$emit('input', $event.target.value)"
            ref="input"
    >
        <option :value="null" disabled>Select item</option>
        <option v-for="(name, value) in options" :value="value">{{ name}}</option>
    </select>
</template>

<script>
    export default {
        props: [
            'value',
            'options'
        ],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>
