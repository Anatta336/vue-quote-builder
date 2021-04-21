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
            </td>
        </tr>

        <!-- row at the bottom for adding new products to quote -->
        <tr>
            <td>
                <select v-model="toAdd.id">
                    <option value="-1">
                        ----
                    </option>
                    <option v-for="product in productsCouldAdd" :key="product.id" :value="product.id">
                        {{ product.name }}
                    </option>
                </select>
            </td>
            <td>
                <input v-model="toAdd.count" type="number">
            </td>
            <td>
                <!-- TODO: on selecting a product from dropdown, update this value -->
                <price-from-pence :pence="toAdd.pricePence"/>
            </td>
            <td>
                <!-- TODO: implement me -->
                <button>Add</button>
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
            toAdd: {
                id: -1,
                count: 0,
                pricePence: 0,
            }
        };
    },
    methods: {
        async getAllProducts() {
            try {
                const response = await axios.get('/api/product')
                this.allProducts = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async getProductsInQuote() {
            try {
                const response = await axios.get(`/api/quote/${this.quoteId}/products`);
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
        increaseCount(product) {
            //TODO: implement me
        },
        decreaseCount(product) {

            // get updated data
            (async () => {
                await this.getProductsInQuote();
                this.updateProductsCouldAdd();
            })();
        },
        addProduct() {
            //TODO: implement me

            (async () => {
                await this.getProductsInQuote();
                this.updateProductsCouldAdd();
            })();
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
