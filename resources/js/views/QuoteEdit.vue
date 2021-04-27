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
                    :product="product"
                    @change-count="changeCount"
                    @remove="removeProduct"
                />
            </template>

            <quote-line-add
                :allProducts="allProducts"
                :productsInQuote="productsInQuote"
                @addProduct="addProduct"
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
                console.error(error);
            }
        },
        async fetchAllProducts() {
            try {
                const response = await axios.get('/api/products')
                this.allProducts = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async fetchProductsInQuote() {
            try {
                const response = await axios.get(`/api/quotes/${this.$route.params.id}/products`);
                this.productsInQuote = response.data;
            } catch (error) {
                console.error(error);
            }
        },

        async changeCount(product, count) {
            if (!product) {
                return;
            }

            // update on frontend
            product.count = count;
            const isProductRemoved = (count <= 0);
            if (isProductRemoved) {
                this.removeProductFromLocalQuote(product);
            }

            // send update to backend
            try {
                await axios.patch(
                    `/api/quotes/${this.quote.id}/products/${product.product_id}`,
                    { 'count': count }
                );
            } catch (error) {
                console.error(error);
            }
        },
        async removeProduct(product) {
            this.removeProductFromLocalQuote(product);

            try {
                await axios.delete(`/api/quotes/${this.quote.id}/products/${product.product_id}`);
            } catch (error) {
                console.error(error);
            }
        },
        async addProduct(product, count) {
            try {
                // add product in frontend
                this.productsInQuote.push({
                    product_id: product.id,
                    name: product.name,
                    price_pence: product.price_pence,
                    count,
                });

                // request to add the product on backend
                await axios.post(`/api/quotes/${this.quote.id}/products/${product.id}`, {
                    'count': count,
                });
            } catch (error) {
                console.error(error);
            }
        },

        removeProductFromLocalQuote(toRemove) {
            this.productsInQuote = this.productsInQuote.filter((productInQuote) => {
                return productInQuote.product_id !== toRemove.product_id;
            });
        }
    },
    mounted() {
        this.fetchQuote();
        this.fetchAllProducts();
        this.fetchProductsInQuote();
    }
}
</script>
