<template>
    <div class="quote-products">
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

            <template
                v-for="product in productsInQuote"
            >
                <quote-line-item
                    :key="product.id"
                    :product="product"
                    @change-count="changeCount"
                    @remove="removeProduct"
                />
            </template>

            <quote-add-product
                :allProducts="allProducts"
                :productsInQuote="productsInQuote"
                @addProduct="addProduct"
            />

        </table>
        <quote-totals
            :productsInQuote="productsInQuote"
            :vatRate="vatRate"
        />
        <div>
            <p>
                Send this quote as an email to {{ customerEmail }}:
                <button :disabled="isAwaitingEmailSend" @click="emailToCustomer">Email</button>
            </p>
            <p v-if="emailFeedback != ''">{{ emailFeedback }}</p>
        </div>
    </div>
</template>
<script>
import PriceFromPence from '../components/PriceFromPence.vue';
import QuoteLineItem from '../components/QuoteLineItem.vue';
import QuoteTotals from '../components/QuoteTotals.vue';
import QuoteAddProduct from '../components/QuoteAddProduct.vue';

export default {
    name: "product-list",
    components: {
        PriceFromPence,
        QuoteLineItem,
        QuoteTotals,
        QuoteAddProduct,
    },
    data() {
        return {
            quoteId: this.$route.params.id, //TODO: will not be needed, instead have quote object

            allProducts: [],
            productsInQuote: [],

            vatRate: 0.2,

            customerEmail: 'example@example.com', //TODO: get this! (will use quote object's properties)
            isAwaitingEmailSend: false,
            emailFeedback: ''
        };
    },
    computed: {
        toAddPricePerItem: function() {
            if (!this.toAddProduct) {
                return 0;
            }
            return this.toAddProduct.price_pence;
        },
        toAddPricePence: function() {
            return this.toAddCount * this.toAddPricePerItem;
        },
    },
    methods: {
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
                const response = await axios.get(`/api/quotes/${this.quoteId}/products`);
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
                    `/api/quotes/${this.quoteId}/products/${product.product_id}`,
                    { 'count': count }
                );
            } catch (error) {
                console.error(error);
            }
        },
        async removeProduct(product) {
            this.removeProductFromLocalQuote(product);

            try {
                await axios.delete(`/api/quotes/${this.quoteId}/products/${product.product_id}`);
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
                await axios.post(`/api/quotes/${this.quoteId}/products/${product.id}`, {
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
        },
        async emailToCustomer() {
            this.isAwaitingEmailSend = true;
            this.emailFeedback = 'Sending email...';
            try {
                const response = await axios.post(`/api/quotes/${this.quoteId}/email`);

                this.isAwaitingEmailSend = false;
                const date = new Date();
                this.emailFeedback = 'Email sent (UTC) '
                    + date.getUTCFullYear()
                    + "/" + (date.getUTCMonth() + 1)
                    + "/" + date.getUTCDate()
                    + " at " + date.getUTCHours()
                    + ":" + date.getUTCMinutes()
                    + ":" + date.getUTCSeconds();
            } catch (error) {
                console.error(error);
                this.emailFeedback = 'An error occurred when attempting to send as email.';
            }
        },
    },
    mounted() {
        this.fetchProductsInQuote();
        this.fetchAllProducts();
    }
}
</script>
