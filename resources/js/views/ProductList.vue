<template>
    <div class="products">
        <product-table :products="products" :idToEdit="idToEdit">

            <!-- slot used to view the row -->
            <template v-slot:product-view="{ product }">
                <product-row-view
                    :product="product"
                    @edit="beginEdit(product)"
                    @delete="deleteProduct(product)"
                ></product-row-view>
            </template>

            <!-- slot used when editing the row -->
            <template v-slot:product-edit="{ product }">
                <product-row-edit
                    :product="product"
                    @update="productUpdated"
                    @delete="deleteProduct(product)"
                ></product-row-edit>
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
import ProductRowView from '../components/products/ProductRowView.vue';
import ProductRowEdit from '../components/products/ProductRowEdit.vue';
import ProductRowAdd from '../components/products/ProductRowAdd.vue';
import ErrorList from '../components/ErrorList.vue';

export default {
    components: {
        PriceFromPence,
        ProductTable,
        ProductRowView,
        ProductRowEdit,
        ProductRowAdd,
        ErrorList,
    },
    name: "product-list",
    data() {
        return {
            products: [],
            idToEdit: -1,
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
            this.idToEdit = product.id;
        },
        productUpdated(id, name, pricePence) {
            // update local product
            const localProduct = this.products.find((product) => product.id === id);
            localProduct.name = name;
            localProduct.price_pence = pricePence;

            // no longer editing product
            this.idToEdit = -1;
        },
        //TODO: rework so delete button does the actual delete, this just updates local, so renamed to "productDeleted"
        async deleteProduct(product) {
            // delete locally
            this.products = this.products.filter((existing) => existing.id != product.id);

            // if editing deleted product, stop editing it
            if (this.idToEdit == product.id) {
                this.idToEdit = -1;
            }

            // request to delete remotely too
            try {
                await axios.delete(`/api/products/${product.id}`);
            } catch(error) {
                console.error(error);
            }
        },
        productAdded() {
            this.fetchProducts();
        },
    },
    mounted() {
        this.fetchProducts();
    }
}
</script>

