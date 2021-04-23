<template>
    <div class="product-index">
        <product-list />
        <router-link class="button" :to="{ name: 'products.add' }">Create</router-link>
    </div>
</template>
<script>
import ProductList from '../components/products/ProductList.vue';

export default {
    name: 'product-index',
    components: {
        ProductList,
    },
}
</script>
