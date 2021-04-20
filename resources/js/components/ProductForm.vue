<template>
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
        <button>Submit</button>
    </form>
</template>
<script>
import ErrorList from './ErrorList.vue';

export default {
    name: 'product-form',
    components: {
        ErrorList,
    },
    props: {
        initialProductName: {
            type: String,
            required: true,
        },
        initialPricePounds: {
            type: Number,
            required: true,
        },
        productId: {
            type: Number,
            required: false,
        },
        errors: {
            type: Object,
            required: false,
        }
    },
    data() {
        return {
            productName: this.initialProductName,
            pricePounds: this.initialPricePounds,
        };
    },
    methods: {
        formSubmit() {
            this.$emit('product-form-submit',
                this.productId ?? -1,
                this.productName,
                this.pricePounds
            );
        }
    }
}
</script>
