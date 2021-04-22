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
            <tr v-for="product in productsInQuote" :key="product.id">
                <td>{{ product.name }}</td>
                <td class="count"><div>{{ product.count }}</div></td>
                <td><price-from-pence :pence="product.price_pence * product.count"/></td>
                <td>
                    <button @click="increaseCount(product)">+</button>
                    <span class="count">{{ product.count }}</span>
                    <button @click="decreaseCount(product)">-</button>
                    <button class="danger" @click="remove(product)">Remove</button>
                </td>
            </tr>

            <!-- row at the bottom for adding new product to quote -->
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
                    <button @click="addProduct">Add</button>
                </td>
            </tr>
        </table>
        <div class="totals">
            <div>
                Sub-Total: <price-from-pence :pence="subTotal" />
            </div>
            <div>
                VAT: <price-from-pence :pence="vatTotal" />
            </div>
            <div class="grand-total">
                Grand Total: <price-from-pence :pence="grandTotal" />
            </div>
        </div>
    </div>
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
            vatRate: 0.2,
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
        subTotal: function() {
            return this.productsInQuote.reduce((sum, product) => {
                return sum + product.price_pence * product.count;
            }, 0)
        },
        vatTotal: function() {
            return this.subTotal * this.vatRate;
        },
        grandTotal: function() {
            return this.subTotal + this.vatTotal;
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
                productInQuote.count++;
                await axios.patch(
                    `/api/quotes/${this.quoteId}/products/${productInQuote.product_id}`,
                    {
                        'count': productInQuote.count,
                    }
                );
            } catch (error) {
                console.error(error);
            }
        },
        async decreaseCount(productInQuote) {
            try {
                // instantly reduce count as stored in frontend, and remove from list if reached zero
                productInQuote.count--;
                const isProductRemoved = (productInQuote.count <= 0);
                if (isProductRemoved) {
                    this.removeProductFromLocalQuote(productInQuote.product_id);
                }

                await axios.patch(`/api/quotes/${this.quoteId}/products/${productInQuote.product_id}`, {
                    'count': productInQuote.count,
                });

                if (isProductRemoved) {
                    // fetch updated product lists to make sure we're in sync
                    await this.getProductsInQuote();
                    this.updateProductsCouldAdd();
                }
            } catch (error) {
                console.error(error);
            }
        },
        async remove(productInQuote) {
            this.removeProductFromLocalQuote(productInQuote.product_id);
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
