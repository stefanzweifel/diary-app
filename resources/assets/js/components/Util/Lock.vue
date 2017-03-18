<template>
    <div>
        <button
            @click="lock"
            class="btn btn-primary navbar-btn"
            v-if="isUnlocked"
        >
            <i class="fa fa-lock"></i> Lock Diary
        </button>
    </div>
</template>

<script>
import * as types from './../../store/mutation-types.js';
import { mapGetters } from 'vuex';

export default {

    computed: {
        ...mapGetters([
          'isUnlocked'
        ])
    },

    methods: {
        lock () {
            this.$store.commit(types.LOCKED);
            this.$router.push('/unlock');
        }
    },
}
</script>