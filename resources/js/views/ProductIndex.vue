<template>
    <div class="product-index">
        <router-link :to="{ name: 'product.add' }">Add</router-link>
        <product-list></product-list>
    </div>
</template>
<script>
import ProductList from '../components/ProductList';

export default {
    components: {
        ProductList,
    },
}
</script>
