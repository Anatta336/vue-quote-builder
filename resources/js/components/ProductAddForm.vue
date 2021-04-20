<template>
    <form @submit.prevent="formSubmit">
        <div>
            <label>
                Name
                <input v-model="productName" type="text">
            </label>
            <error-list :errors="errors['name']"/>
        </div>
        <div>
            <label>
                Price (£)
                <input v-model="pricePounds" type="text">
            </label>
            <error-list :errors="errors['price_pence']"/>
        </div>
        <button>Submit</button>
    </form>
</template>
<script>
import ErrorList from './ErrorList.vue';

export default {
    name: 'product-add-form',
    components: {
        ErrorList,
    },
    data() {
        return {
            productName: 'Test',
            pricePounds: 0,
            errors: [],
        };
    },
    methods: {
        formSubmit() {
            axios.post('/api/product/add', {
                    'name': this.productName,
                    'price_pence': Math.round(this.pricePounds * 100),
                }
            ).then((response) => {
                console.log(response);

                // redirect to the product index route
                this.$router.push({ name: 'product.index' });
            }).catch((error) => {
                // console.log("error object's keys:");
                // Object.keys(error).forEach(key => {
                //     console.log(key);
                // });
                console.log(error.response);
                console.log(error.response.data.errors);
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>
