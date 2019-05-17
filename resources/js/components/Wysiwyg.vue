<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value">
        <trix-editor ref="trix" class="trix-content" input="trix" :placeholder="placeholder"/>
    </div>
</template>


<script>
    import Trix from 'trix';

    Vue.config.ignoredElements = ['trix-editor'];

    export default {
        props: ['name', 'value', 'placeholder', 'shouldClear'],

        mounted() {
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });

            this.$watch('shouldClear', () => {
                this.$refs.trix.value = '';
            });
        }
    }
</script>
