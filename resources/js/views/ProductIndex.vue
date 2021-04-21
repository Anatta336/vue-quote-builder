<template>
    <div class="product-index">
        <product-list></product-list>
        <router-link class="button" :to="{ name: 'products.add' }">Create</router-link>
    </div>
</template>
<script>
import ProductList from '../components/ProductList';

export default {
    name: 'product-index',
    components: {
        ProductList,
    },
}
</script>
