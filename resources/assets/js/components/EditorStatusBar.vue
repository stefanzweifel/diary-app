<template>
    <div v-if="wordCount > 0">
        {{ wordCount }} Words
    </div>
</template>

<script>
import count from 'word-count';

export default {
    props: ['content'],

    computed: {
        wordCount() {
            return count(this.content);
        }
    }
}
</script>