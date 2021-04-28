<template>
    <div v-if="quote" class="quote-view">
        <h1>View Quote</h1>

        <quote-customer-view :quote="quote"/>

        <table>
            <tr>
                <th>Product</th>
                <th>Count</th>
                <th>Line Price</th>
            </tr>

            <tr v-if="!productsInQuote">
                <th>No products in quote.</th>
            </tr>

            <template v-for="product in productsInQuote">
                <quote-line-view
                    :key="product.id"
                    :product="product"
                />
            </template>
        </table>

        <quote-totals
            :productsInQuote="productsInQuote"
            :vatRate="vatRate"
        />

        <router-link
            class="button"
            :to="{
                name: 'quotes.edit',
                params: { id: quote.id }
            }"
        >
            Edit
        </router-link>

        <quote-email :quote="quote"/>
    </div>
</template>
<script>
import QuoteCustomerView from '../components/quotes/QuoteCustomerView.vue';
import QuoteLineView from '../components/quotes/QuoteLineView.vue';
import QuoteTotals from '../components/quotes/QuoteTotals.vue';
import QuoteEmail from '../components/quotes/QuoteEmail.vue';

export default {
    name: "quote-view",
    components: {
        QuoteCustomerView,
        QuoteLineView,
        QuoteTotals,
        QuoteEmail,
    },
    data() {
        return {
            quote: null,
            productsInQuote: [],
            vatRate: 0.2,
        }
    },
    methods: {
        async fetchQuote() {
            try {
                const response = await axios.get(`/api/quotes/${this.$route.params.id}`)
                this.quote = response.data;
            } catch (error) {
                console.warn(error);
            }
        },
        async fetchProductsInQuote() {
            try {
                const response = await axios.get(`/api/quotes/${this.$route.params.id}/products`);
                this.productsInQuote = response.data;
            } catch (error) {
                console.warn(error);
            }
        },
    },
    mounted() {
        this.fetchQuote();
        this.fetchProductsInQuote();
    }
}
</script>
