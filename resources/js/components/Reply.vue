<template>
    <div :id="'reply-'+id" class="py-2">
        <div class="card" :class="isBest ? 'border-success' : 'border-default'">
            <div class="card-header bg-white">
                <div class="level">
                    <div class="card-title flex">
                        <a :href="'/profiles/' + reply.owner.name"
                            v-text="reply.owner.name">
                        </a>
                        said <span v-text="ago"></span>
                    </div>

                    <div v-if="signedIn">
                        <favorite :reply="reply"></favorite>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="editing">
                    <form @submit.prevent="update">
                        <div class="form-group">
                            <wysiwyg v-model="body"></wysiwyg>
                        </div>

                        <button class="btn btn-sm btn-primary">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                    </form>
                </div>

                <div v-else v-html="body"></div>
            </div>

            <div class="card-footer bg-white level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
                <div v-if="authorize('owns', reply)">
                    <button class="btn btn-success btn-sm mr-2" @click="editing = true">Edit</button>
                    <button class="btn btn-sm btn-danger mr-2" @click="destroy">Delete</button>
                </div>

                <button class="btn btn-sm btn-outline-dark ml-auto" @click="markBestReply" v-if="authorize('owns', reply.thread)">Best Reply</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        component: { Favorite },

        data() {
            return {
                editing: false,
                body: this.reply.body,
                id: this.reply.id,
                isBest: this.reply.isBest
            };
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow() + ' ...';
            }
        },

        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });

        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.id, {
                    body: this.body
                })
                .catch(error => {
                    flash(error.response.reply, 'danger');
                })
                .then(({}) => {
                    this.editing = false;
                    flash('Updated');
                });
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }

</script>
