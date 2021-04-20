<template>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <tr v-if="!products">
            <th>No products found.</th>
        </tr>
        <tr v-for="product in products" :key="product.id">
            <td>{{ product.name }}</td>
            <td>£{{ (product.price_pence / 100).toFixed(2) }}</td>
            <td>
                <button @click="editProduct(product)">Edit</button>
                <button @click="deleteProduct(product)">Delete</button>
                </td>
        </tr>
    </table>
</template>
<script>
export default {
    name: "product-list",
    data() {
        return {
            products: [],
        };
    },
    methods: {
        getProducts() {
            axios.get('/api/product').then((response) => {
                this.products = response.data;
            }).catch((error) => {
                console.error(error);
            });
        },
        editProduct(product) {
            this.$router.push({
                name: 'product.edit',
                params: {
                    id: product.id,
                },
            });
        },
        deleteProduct(product) {
            //TODO: confirm deletion

            axios.delete(`/api/product/${product.id}`).then((response) => {
                // refresh list of products as it should have changed
                this.getProducts();
            }).catch((error) => {
                console.error(error);
            });
        },
    },
    mounted() {
        this.getProducts();
    }
}
</script>
