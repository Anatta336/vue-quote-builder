<template>
    <ul>
        <li v-for="product in products" :key="product.id">
            {{ product.name }} £{{ (product.price_pence / 100).toFixed(2) }}
        </li>
    </ul>
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
        },
        mounted() {
            console.log('Component mounted.')
            this.getProducts();
        }
    }
</script>
