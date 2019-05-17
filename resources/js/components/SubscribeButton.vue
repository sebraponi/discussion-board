<template>
    <div>
        <button :class="classes" @click="subscribe">Subscribe</button>
    </div>
</template>

<script>
    export default {

        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-outline-secondary' : 'btn-outline-primary'];
            }
        },

        methods: {
            subscribe() {

                axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscriptions');

                this.active = ! this.active;

            }
        }

    }

</script>
