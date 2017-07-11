<template>
    <div>
        <div class="form-group dropzone" @drop.prevent="readFiles" @dragover.prevent="showMessage">
            DROP IMAGES HERE
        </div>
    </div>
</template>


<script>
import Crypto from './../../classes/Crypto.js';

export default {

    props: ['files', 'entryId'],

    methods: {

        showMessage (event) {
            // Do stuff when user is hovering with files
        },

        readFiles (event) {
            let files = event.target.files || event.dataTransfer.files;
            for (var i = 0; i < files.length; i++) {
                this.createImage(files[i]);

                this.$store.dispatch('storeMedia', {
                    entryId: this.entryId,
                    blob: files[i],
                    // blob: new Crypto(this.$store.state.encryption_password).encrypt(e.target.result)
                });

            }
        },

        createImage(file) {
            let reader = new FileReader();
            let vm = this;

            reader.onload = (e) => {

                vm.files.push({
                    uri: e.target.result,
                    uri_encrypted: new Crypto(this.$store.state.encryption_password).encrypt(e.target.result),
                    last_modified: file.lastModified,
                    name: file.name,
                    size: file.size,
                    type: file.type
                })

                // Upload to Server
                // Append to Entry View
                // Redownload Entry Fiels
            };
            reader.readAsDataURL(file);
        }

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