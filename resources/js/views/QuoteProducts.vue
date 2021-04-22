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
                v-for="productInQuote in productsInQuote"
            >
                <quote-line-item
                    :key="productInQuote.id"
                    v-bind="productInQuote"
                    @change-count="onCountChange"
                    @remove="onRemove"
                />
            </template>

            <!-- row at the bottom for adding new product to quote -->
            <!-- TODO: this could be moved into its own component -->
            <tr>
                <td>
                    <select v-model="toAddProduct">
                        <option :value="null">
                            ----
                        </option>
                        <option v-for="product in productsCouldAdd" :key="product.id" :value="product">
                            {{ product.name }}
                        </option>
                    </select>
                </td>
                <td class="count"><div>
                    <input v-model="toAddCount" type="number" min="1" step="1">
                </div></td>
                <td>
                    <price-from-pence class="preview" :pence="toAddPricePence"/>
                </td>
                <td>
                    <button :disabled="!toAddProduct" @click="addProduct">
                        Add
                    </button>
                </td>
            </tr>
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

export default {
    name: "product-list",
    components: {
        PriceFromPence,
        QuoteLineItem,
        QuoteTotals,
    },
    data() {
        return {
            quoteId: this.$route.params.id,
            productsInQuote: [],
            allProducts: [],
            productsCouldAdd: [],
            toAddProduct: null,
            toAddCount: 1,
            vatRate: 0.2,
            customerEmail: 'example@example.com', //TODO: get this!
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
    watch: {
        toAddCount: function(value) {
            if (value < 1) {
                this.toAddCount = 1;
            }
        }
    },
    methods: {
        async getAllProducts() {
            try {
                const response = await axios.get('/api/products')
                this.allProducts = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async getProductsInQuote() {
            try {
                const response = await axios.get(`/api/quotes/${this.quoteId}/products`);
                this.productsInQuote = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        updateProductsCouldAdd() {
            // only include products that aren't already in the quote
            this.productsCouldAdd = this.allProducts.filter((product) => {
                return !this.productsInQuote.some((inQuote) => {
                    return product.id === inQuote.product_id;
                });
            });
        },
        async onCountChange(product_id, count) {
            // find the product that changed
            const productInQuote = this.getProductInQuoteById(product_id);
            if (!productInQuote) {
                return;
            }

            // update on frontend
            productInQuote.count = count;
            const isProductRemoved = (count <= 0);
            if (isProductRemoved) {
                this.removeProductFromLocalQuote(product_id);
                this.updateProductsCouldAdd();
            }

            // send update to backend
            try {
                await axios.patch(
                    `/api/quotes/${this.quoteId}/products/${product_id}`,
                    { 'count': count }
                );
            } catch (error) {
                console.error(error);
            }
        },
        async onRemove(product_id) {
            this.removeProductFromLocalQuote(product_id);
            this.updateProductsCouldAdd();

            try {
                await axios.delete(`/api/quotes/${this.quoteId}/products/${product_id}`);
            } catch (error) {
                console.error(error);
            }
        },
        getProductInQuoteById(id) {
            return this.productsInQuote.find((product) => product.product_id === id);
        },
        async addProduct() {
            if (!this.toAddProduct) {
                // TODO: display a "please select a product" warning.
                // or, disable the "add" button when no product is selected (style it too)
                return;
            }

            try {
                const product = this.toAddProduct;
                const count = this.toAddCount;

                // reset form
                this.toAddProduct = null;
                this.toAddCount = 1;

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

                // update list of products
                await this.getProductsInQuote();
                this.updateProductsCouldAdd();
            } catch (error) {
                console.error(error);
            }
        },
        removeProductFromLocalQuote(idToRemove) {
            this.productsInQuote = this.productsInQuote.filter((productInQuote) => {
                return productInQuote.product_id !== idToRemove;
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
        (async () => {
            await Promise.all([
                this.getProductsInQuote(),
                this.getAllProducts(),
            ]);

            // once both requests are done, can use their data
            this.updateProductsCouldAdd();
        })();
    }
}
</script>
