<template>
    <div class="product-add">
        <h1>Create Product</h1>
        <form @submit.prevent="formSubmit">
            <div>
                <label>
                    Name
                    <input v-model="productName" type="text">
                </label>
                <error-list v-if="errors" :errors="errors['name']"/>
            </div>
            <div>
                <label>
                    Price (£)
                    <input v-model="pricePounds" type="text">
                </label>
                <error-list v-if="errors" :errors="errors['price_pounds']"/>
            </div>
            <button>Create</button>
        </form>
    </div>
</template>
<script>
import ErrorList from '../components/ErrorList.vue';

export default {
    name: 'product-add',
    components: {
        ErrorList,
    },
    data() {
        return {
            productName: '',
            pricePounds: 0,
            errors: {},
        }
    },
    methods: {
        formSubmit() {
            axios.post('/api/products', {
                    'name': this.productName,
                    'price_pounds': this.pricePounds,
                }
            ).then(() => {
                //TODO: display a "product added" message?

                // redirect to the product index route
                this.$router.push({ name: 'products.index' });
            }).catch((error) => {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>
