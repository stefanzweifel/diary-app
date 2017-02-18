<template>
    <div
        class="o-journal-element list-group-item"
        v-on:click="selectEntry"
        v-bind:class="{ active: isActive }"
    >
        <p class="list-group-item-text">
            {{ formatedDate }}

            <br><br>

            {{ entry.content }}
            <br>
            ID: <code>{{ entry.id }}</code>
        </p>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {

        props: ['entry'],

        mounted() {
            // console.log("Editor Mounted");
        },

        data: () => {
            return {
                isActive: false
            }
        },

        computed: {
            formatedDate () {
                return moment(this.entry.created_at).format();
            }
        },

        methods: {
            selectEntry () {
                this.isActive = true;
                this.$emit('selectEntry', this.entry);
            }
        }
    }
</script>

<style scoped>
    .list-group-item:hover {
        cursor: pointer;
        /*background-color: #f1f1f1;*/
    }
</style>

