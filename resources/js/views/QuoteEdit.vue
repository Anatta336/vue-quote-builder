<template>
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
            :vatRate="vatRate"
        />

        <quote-email :quote="quote"/>
    </div>
</template>
<script>
import QuoteCustomerEdit from '../components/quotes/QuoteCustomerEdit.vue';
import QuoteLineEdit from '../components/quotes/QuoteLineEdit.vue';
import QuoteLineAdd from '../components/quotes/QuoteLineAdd.vue';
import QuoteTotals from '../components/quotes/QuoteTotals.vue';
import QuoteEmail from '../components/quotes/QuoteEmail.vue';

export default {
    name: "quote-edit",
    components: {
        QuoteCustomerEdit,
        QuoteLineEdit,
        QuoteLineAdd,
        QuoteTotals,
        QuoteEmail,
    },
    data() {
        return {
            quote: null,

            allProducts: [],
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
        async fetchAllProducts() {
            try {
                const response = await axios.get('/api/products')
                this.allProducts = response.data;
            } catch (error) {
                console.warn(error);
            }
        },
        async fetchProductsInQuote() {
            try {
                const response = await axios.get(`/api/quotes/${this.$route.params.id}/products`);
                this.productsInQuote = response.data.map((responseProduct) => {
                    // the response has:  .product_id, .name, .price_pence, .count
                    // but want to store:         .id, .name, .price_pence, .count
                    return {
                        ...responseProduct,
                        id: responseProduct.product_id,
                        product_id: undefined,
                    };
                });

                this.productsInQuote = response.data;
            } catch (error) {
                console.warn(error);
            }
        },

        addProductToLocal(product, count) {
            if (!product) {
                return;
            }

            this.productsInQuote.push({
                ...product,
                count,
            });
        },
        changeCountInLocal(product, newCount) {
            if (!product) {
                return;
            }

            product.count = newCount;
            if (newCount <= 0) {
                this.removeProductFromLocal(product);
            }
        },
        removeProductFromLocal(product) {
            if (!product) {
                return;
            }

            this.productsInQuote = this.productsInQuote.filter((productInQuote) => {
                return productInQuote.id !== product.id;
            });
        },
    },
    mounted() {
        this.fetchQuote();
        this.fetchAllProducts();
        this.fetchProductsInQuote();
    }
}
</script>
