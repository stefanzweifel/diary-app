<template>
    <router-link :to="{ name: 'entries.preview', params: { entryId: entry.id }}" class="bg-blue hover:bg-blue-dark inline-block text-white no-underline font-bold py-2 px-4 rounded cursor-pointer">
        Read
    </router-link>
</template>

<script>
export default {
    props: ['entry']
}
</script>
