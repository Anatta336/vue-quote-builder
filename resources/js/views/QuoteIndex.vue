<template>
    <div class="quote-index">
        <quote-list />
        <router-link class="button" :to="{ name: 'quotes.add' }">Create</router-link>
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
