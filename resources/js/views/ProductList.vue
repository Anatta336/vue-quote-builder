<template>
    <div class="products">
        <product-table :products="products" :toEdit="toEdit">

            <!-- slot used to view the row -->
            <template v-slot:product-view="{ product }">
                <td>
                    {{ product.name }}
                </td>
                <td>
                    <price-from-pence :pence="product.price_pence" />
                </td>
                <td>
                    <button @click="beginEdit(product)">Edit</button>
                    <button class="danger" @click="deleteProduct(product)">Delete</button>
                </td>
            </template>

            <!-- TODO: can pull these into separate components, by having the for loop on a template instead of <tr> -->

            <!-- slot used when editing the row -->
            <template v-slot:product-edit="{ product }">
                <td>
                    <form @submit.prevent="updateProduct">
                        <input v-model="toEdit.name" type="text">
                        <error-list :errors="editErrors.name"/>
                    </form>
                </td>
                <td>
                    <form @submit.prevent="updateProduct">
                        £<input v-model="toEdit.price_pounds" type="text">
                        <error-list :errors="editErrors.price_pence"/>
                    </form>
                </td>
                <td>
                    <button @click="updateProduct(product)">Store</button>
                    <button class="danger" @click="deleteProduct(product)">Delete</button>
                </td>
            </template>

            <!-- slot for row(s) after the existing product rows -->
            <template v-slot:after-table-rows>
                <product-row-add
                    @add="productAdded"
                ></product-row-add>
            </template>
        </product-table>
    </div>
</template>
<script>
import PriceFromPence from '../components/PriceFromPence.vue';
import ProductTable from '../components/products/ProductTable.vue';
import ProductRowAdd from '../components/products/ProductRowAdd.vue';
import ErrorList from '../components/ErrorList.vue';

export default {
    components: {
        PriceFromPence,
        ProductTable,
        ProductRowAdd,
        ErrorList,
    },
    name: "product-list",
    data() {
        return {
            products: [],
            toEdit: null,
            editErrors: [],
            toAdd: {
                name: '',
                price_pounds: '0.00',
            },
            addErrors: [],
        };
    },
    methods: {
        async fetchProducts() {
            try {
                const response = await axios.get('/api/products');
                this.products = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        beginEdit(product) {
            if (this.toEdit && this.toEdit.id == product.id) {
                // already editing target, so nothing to do
                return;
            }

            // make a copy of the product to work on
            this.toEdit = { ... product } ;
            this.toEdit.price_pounds = (product.price_pence * 0.01).toFixed(2);

            // clear any errors, as they don't apply to the new edit target
            this.editErrors = [];
        },
        async updateProduct() {
            try {
                await axios.patch(`/api/products/${this.toEdit.id}`, {
                    'name': this.toEdit.name,
                    'price_pence': this.toEdit.price_pounds * 100,
                });

                // update locally (only reach here if no validation errors)
                const localProduct = this.products.find((product) => product.id === this.toEdit.id);
                localProduct.name = this.toEdit.name;
                localProduct.price_pence = this.toEdit.price_pounds * 100;

                // after storing, no longer editing anything
                this.toEdit = null;
                this.editErrors = [];
            } catch (error) {
                if (error?.response?.data?.errors) {
                    this.editErrors = error.response.data.errors;
                } else {
                    console.error(error);
                }
            }
        },
        async deleteProduct(product) {
            // delete locally
            this.products = this.products.filter((existing) => existing.id != product.id);

            // if editing deleted product, stop editing it
            if (this.toEdit && this.toEdit.id == product.id) {
                this.toEdit = null;
            }

            // request to delete remotely too
            try {
                await axios.delete(`/api/products/${product.id}`);
            } catch(error) {
                console.error(error);
            }
        },
        productAdded(productName, pricePence) {
            this.fetchProducts();
        },
    },
    mounted() {
        this.fetchProducts();
    }
}
</script>

