<template>
<ul class="product-list">
    <li v-for="product in products" :key="product.id">
        {{ product.name }}
    </li>
</ul>
</template>

<script>
    export default {
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
