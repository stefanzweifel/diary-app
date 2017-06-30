<template>
    <div>
        {{ wordCount }} Words
    </div>
</template>

<script>
import count from 'word-count';

export default {
    props: ['entry', 'content'],

    computed: {
        wordCount() {
            return count(this.content);
        }
    }
}
</script>