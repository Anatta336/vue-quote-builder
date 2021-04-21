<template>
    <div class="product-index">
        <router-link :to="{ name: 'product.add' }">Create</router-link>
        <product-list></product-list>
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
