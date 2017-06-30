<template>
    <router-link :to="{ name: 'entries.preview', params: { entryId: entry.id }}" class="btn btn-primary">
        Read
    </router-link>
</template>

<script>
export default {
    props: ['entry']
}
</script>