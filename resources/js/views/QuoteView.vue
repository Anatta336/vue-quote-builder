<template>
    <fetch-quote
        v-slot:default="{
            quote,
            productsInQuote,
        }"
    >
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
    </fetch-quote>
</template>
<script>
import fetchQuote from '../components/quotes/fetchQuote.js';
import QuoteCustomerView from '../components/quotes/QuoteCustomerView.vue';
import QuoteLineView from '../components/quotes/QuoteLineView.vue';
import QuoteTotals from '../components/quotes/QuoteTotals.vue';
import QuoteEmail from '../components/quotes/QuoteEmail.vue';

export default {
    name: "quote-view",
    components: {
        fetchQuote,
        QuoteCustomerView,
        QuoteLineView,
        QuoteTotals,
        QuoteEmail,
    },
}
</script>
