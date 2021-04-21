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
    /* TODO: move to add product to quote component
    methods: {
        formSubmit() {
            axios.post('/api/quote/2', {
                    'product_id': this.productId,
                    'count': this.count,
                }
            ).then((response) => {
                console.log(response);
            }).catch((error) => {
                console.error(error);
            });
        }
    }
    */
}
</script>
