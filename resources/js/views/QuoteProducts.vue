<template>
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
        <tr v-for="product in productsInQuote" :key="product.id">
            <td>{{ product.name }}</td>
            <td>{{ product.count }}</td>
            <td><price-from-pence :pence="product.price_pence * product.count"/></td>
            <td>
                <button @click="increaseCount(product)">+</button>
                <span class="count">{{ product.count }}</span>
                <button @click="decreaseCount(product)">-</button>
                <button class="danger" @click="remove(product)">Remove</button>
            </td>
        </tr>

        <!-- row at the bottom for adding new products to quote -->
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
            <td>
                <input v-model="toAddCount" type="number" min="1" step="1">
            </td>
            <td>
                <price-from-pence class="preview" :pence="toAddPricePence"/>
            </td>
            <td>
                <button @click="addProduct">Add</button>
            </td>
        </tr>
    </table>
</template>
<script>
import PriceFromPence from '../components/PriceFromPence.vue';
export default {
    name: "product-list",
    components: {
        PriceFromPence,
    },
    data() {
        return {
            quoteId: this.$route.params.id,
            productsInQuote: [],
            allProducts: [],
            productsCouldAdd: [],
            toAddProduct: null,
            toAddCount: 1,
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
        }
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
        async increaseCount(productInQuote) {
            try {
                await axios.patch(
                    `/api/quotes/${this.quoteId}/products/${productInQuote.product_id}`,
                    {
                        'count': parseInt(productInQuote.count) + 1,
                    }
                );
                this.getProductsInQuote();
            } catch (error) {
                console.error(error);
            }
        },
        async decreaseCount(productInQuote) {
            try {
                await axios.patch(`/api/quotes/${this.quoteId}/products/${productInQuote.product_id}`, {
                    'count': parseInt(productInQuote.count) - 1,
                });
                await this.getProductsInQuote();
                this.updateProductsCouldAdd();
            } catch (error) {
                console.error(error);
            }
        },
        async remove(productInQuote) {
            try {
                await axios.delete(`/api/quotes/${this.quoteId}/products/${productInQuote.product_id}`);
                await this.getProductsInQuote();
                this.updateProductsCouldAdd();
            } catch (error) {
                console.error(error);
            }
        },
        async addProduct() {
            if (!this.toAddProduct) {
                // TODO: display a "please select a product" warning
                return;
            }

            try {
                // add the product
                await axios.post(`/api/quotes/${this.quoteId}/products/${this.toAddProduct.id}`, {
                    'count': this.toAddCount,
                });

                // reset form
                this.toAddProduct = null;
                this.toAddCount = 1;

                // update list of products
                await this.getProductsInQuote();
                this.updateProductsCouldAdd();
            } catch (error) {
                console.error(error);
            }
        }
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
