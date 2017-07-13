<template>
    <div>
        <div class="form-group dropzone" @drop.prevent="readFiles" @dragover.prevent="dragover">
            DROP MEDA FILES HERE
        </div>
    </div>
</template>


<script>
import Crypto from './../../classes/Crypto.js';

export default {

    props: ['entryId'],

    methods: {

        dragover(event) {
            //
        },

        readFiles (event) {
            let files = event.target.files || event.dataTransfer.files;
            for (var i = 0; i < files.length; i++) {

                this.$store.dispatch('storeMedia', {
                    entryId: this.entryId,
                    blob: files[i],
                });

            }
        },


    }

}
</script>

<style scoped>
    .dropzone {
       border: 2px dashed #bbb;
        border-radius: 5px;
        padding: 25px;
        text-align: center;
        font-size: 1.2em;
        font-weight: bold;
        color: #bbb;
    }
</style>