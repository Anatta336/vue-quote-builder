<template>
    <div class="quote-index">
        <router-link :to="{ name: 'quote.add' }">Create</router-link>
        <quote-list />
    </div>
</template>
<script>
import QuoteList from '../components/QuoteList.vue';

export default {
    name: 'quote-index',
    components: {
        QuoteList,
    },
}
</script>
