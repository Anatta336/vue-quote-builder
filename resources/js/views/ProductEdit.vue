<template>
    <div class="product-edit">
        <h1>Edit Product</h1>
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
            <button>Edit</button>
        </form>
    </div>
</template>
<script>
import ErrorList from '../components/ErrorList.vue';

export default {
    components: {
        ErrorList,
    },
    data() {
        return {
            id: this.$route.params.id,
            productName: '',
            pricePounds: 0,
            errors: {},
        }
    },
    methods: {
        getDetails() {
            axios.get(`/api/product/${this.id}`)
            .then((response) => {
                this.productName = response.data.name;
                this.pricePounds = (response.data.price_pence / 100).toFixed(2);
            }).catch((error) => {
                console.error(error);
            });
        },
        formSubmit() {
            axios.put(`/api/product/${this.id}`, {
                    'name': this.productName,
                    'price_pounds': this.pricePounds,
                }
            ).then(() => {
                //TODO: display a "product edited" success message

                // redirect to the product index route
                this.$router.push({ name: 'product.index' });
            }).catch((error) => {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    },
    mounted() {
        this.getDetails();
    }
}
</script>
