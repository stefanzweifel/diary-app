<template>
    <div>
        <button
            @click="lock"
            class="btn btn-primary navbar-btn"
        >
            <i class="fa fa-lock"></i> Lock Diary
        </button>
    </div>
</template>

<script>
    import * as types from './../../store/mutation-types.js';

    export default {
        methods: {
            lock () {
                return this.$store.commit(types.LOCKED);
            }
        },
    }
</script>