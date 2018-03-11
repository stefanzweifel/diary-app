<template>
    <div class="text-xs dropzone" @drop.prevent="readFiles" @dragover.prevent="dragover">
        Drop Images Here
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
       padding: 20px;
       text-align: center;
       font-weight: bold;
       color: #bbb;

       text-transform: uppercase;
    }
</style>
