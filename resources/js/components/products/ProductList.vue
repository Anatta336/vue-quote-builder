<template>
    <product-table :products="products" :toEdit="toEdit">

        <!-- slot used by default (to view the row) -->
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

        <!-- slot used when editing the row -->
        <template v-slot:product-edit="{ product }">
            <td>
                <form @submit.prevent="storeProduct">
                    <input v-model="toEdit.name" type="text">
                    <error-list :errors="errors.name"/>
                </form>
            </td>
            <td>
                <form @submit.prevent="storeProduct">
                    £<input v-model="toEdit.price_pounds" type="text">
                    <error-list :errors="errors.price_pence"/>
                </form>
            </td>
            <td>
                <button @click="storeProduct(product)">Store</button>
                <button class="danger" @click="deleteProduct(product)">Delete</button>
            </td>
        </template>

<!--
    on click "store" don't immediately update locally
    wait until response comes back, update local and end edit iff no validation errors
    when there are errors, display them in the slot

    when changing which is being edited, clear errors
-->

    </product-table>
</template>
<script>
import PriceFromPence from '../PriceFromPence.vue';
import ProductTable from '../products/ProductTable.vue';
import ErrorList from '../ErrorList.vue';

export default {
    components: {
        PriceFromPence,
        ProductTable,
        ErrorList,
    },
    name: "product-list",
    data() {
        return {
            products: [],
            toEdit: null,
            errors: []
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
            this.errors = [];
        },
        async storeProduct() {
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
                this.errors = [];
            } catch (error) {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error(error);
                }
            }
        },
        async deleteProduct(product) {
            // delete locally
            this.products = this.products.filter((existing) => existing.id != product.id);

            // if editing deleted product, stop editing it
            if (this.toEdit.id == product.id) {
                this.toEdit = null;
            }

            // request to delete remotely too
            try {
                await axios.delete(`/api/products/${product.id}`);
            } catch(error) {
                console.error(error);
            }
        },
    },
    mounted() {
        this.fetchProducts();
    }
}
</script>
