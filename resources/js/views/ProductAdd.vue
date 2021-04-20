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
    //TODO: make the "ProductAddForm" into a general purpose product form,
    // with the submission and filling handled externally (i.e. here).
    // So it can be used both for creation and editing.
}
</script>
