<template>
    <div class="products">
        <product-table :products="products" :idToEdit="idToEdit">

            <!-- slot used to view the row -->
            <template v-slot:product-view="{ product }">
                <product-row-view
                    :product="product"
                    @edit="beginEdit(product)"
                    @delete="productDeleted(product.id)"
                ></product-row-view>
            </template>

            <!-- slot used when editing the row -->
            <template v-slot:product-edit="{ product }">
                <product-row-edit
                    :product="product"
                    @update="productUpdated"
                    @delete="productDeleted(product.id)"
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
import ProductTable from '../components/products/ProductTable.vue';
import ProductRowView from '../components/products/ProductRowView.vue';
import ProductRowEdit from '../components/products/ProductRowEdit.vue';
import ProductRowAdd from '../components/products/ProductRowAdd.vue';

export default {
    components: {
        ProductTable,
        ProductRowView,
        ProductRowEdit,
        ProductRowAdd,
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
            // update product in local collection
            const localProduct = this.products.find((product) => product.id === id);
            localProduct.name = name;
            localProduct.price_pence = pricePence;

            // no longer editing product
            this.idToEdit = -1;
        },
        productDeleted(id) {
            // remove from local collection
            this.products = this.products.filter((existing) => existing.id !== id);

            // if editing deleted product, stop editing it
            if (this.idToEdit === id) {
                this.idToEdit = -1;
            }
        },
        productAdded() {
            // needt to actually fetch data, as don't know what ID it was assigned
            this.fetchProducts();
        },
    },
    mounted() {
        this.fetchProducts();
    }
}
</script>
