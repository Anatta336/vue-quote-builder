<template>
    <div class="product-add">
        <h1>Add Product</h1>
        <product-form
            :initial-product-name="productName"
            :initial-price-pounds="pricePounds"
            :errors="errors"
            @product-form-submit="formSubmit"
        />
    </div>
</template>
<script>
import ProductForm from '../components/ProductForm.vue';

export default {
    components: {
        ProductForm,
    },
    data() {
        return {
            productName: '',
            pricePounds: 0,
            errors: {},
        }
    },
    methods: {
        formSubmit(productId, productName, pricePounds) {
            console.log('ProductAdd.vue got form submit event'); //TODO: temp

            axios.post('/api/product', {
                    'name': productName,
                    'price_pounds': pricePounds,
                }
            ).then((response) => {
                console.log('add submit was a success');

                //TODO: display a "product added" message?

                // on success redirect to the product index route
                this.$router.push({ name: 'product.index' });
            }).catch((error) => {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>
