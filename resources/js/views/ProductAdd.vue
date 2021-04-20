<template>
    <div class="product-add">
        <h1>Add Product</h1>
        <product-add-form></product-add-form>
    </div>
</template>
<script>
import ProductAddForm from '../components/ProductAddForm.vue';

export default {
    components: {
        ProductAddForm,
    },
}
</script>
