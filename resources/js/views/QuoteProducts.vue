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
            <td>£{{ (product.price_pence / 100).toFixed(2) }}</td>
            <td>
                <!-- TODO: attach methods to buttons -->
                <button>+</button>
                <input v-model="product.count" type="number">
                <button>-</button>
            </td>
        </tr>
    </table>
</template>
<script>
export default {
    name: "product-list",
    data() {
        return {
            quoteId: this.$route.params.id,
            productsInQuote: [],
        };
    },
    methods: {
        getProducts() {
            axios.get(`/api/quote/${this.quoteId}/products`).then((response) => {
                this.productsInQuote = response.data;
                console.log(`fetched products for quote ${this.quoteId}`);
                console.log(response.data);
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
