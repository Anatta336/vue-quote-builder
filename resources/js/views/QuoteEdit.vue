<template>
    <fetch-quote
        v-slot:default="{
            fetchProductsInQuote,
            quote,
            allProducts,
            productsInQuote,
            addProductToLocal,
            changeCountInLocal,
            removeProductFromLocal,
        }"
    >
        <div v-if="quote" class="quote-edit">
            <h1>Edit Quote</h1>

            <quote-customer-edit :quote="quote"/>

            <table>
                <tr>
                    <th>Product</th>
                    <th>Count</th>
                    <th>Line Price</th>
                    <th>Actions</th>
                </tr>

                <tr v-if="!productsInQuote">
                    <th>No products in quote.</th>
                </tr>

                <template v-for="product in productsInQuote">
                    <quote-line-edit
                        :key="product.id"
                        :quoteId="parseInt(quote.id)"
                        :product="product"
                        @change-count-begin="(product, newCount, oldCount) => changeCountInLocal(product, newCount)"
                        @change-count-error="fetchProductsInQuote()"
                        @remove-begin="removeProductFromLocal(product)"
                        @remove-error="fetchProductsInQuote()"
                    />
                </template>

                <quote-line-add
                    :quoteId="parseInt(quote.id)"
                    :allProducts="allProducts"
                    :productsInQuote="productsInQuote"
                    @add-product-begin="(product, count) => addProductToLocal(product, count)"
                    @add-product-error="fetchProductsInQuote()"
                />
            </table>

            <quote-totals
                :productsInQuote="productsInQuote"
            />

            <quote-email :quote="quote"/>
        </div>
    </fetch-quote>
</template>
<script>
import fetchQuote from '../components/quotes/fetchQuote.js';
import QuoteCustomerEdit from '../components/quotes/QuoteCustomerEdit.vue';
import QuoteLineEdit from '../components/quotes/QuoteLineEdit.vue';
import QuoteLineAdd from '../components/quotes/QuoteLineAdd.vue';
import QuoteTotals from '../components/quotes/QuoteTotals.vue';
import QuoteEmail from '../components/quotes/QuoteEmail.vue';

export default {
    name: "quote-edit",
    components: {
        fetchQuote,
        QuoteCustomerEdit,
        QuoteLineEdit,
        QuoteLineAdd,
        QuoteTotals,
        QuoteEmail,
    },
}
</script>
