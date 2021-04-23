<template>
    <tr>
        <td>
            <form @submit.prevent="storeProduct">
                <input v-model="productName" type="text">
                <error-list :errors="errors.name"/>
            </form>
        </td>
        <td>
            <form @submit.prevent="storeProduct">
                £<input v-model="pricePounds" type="text">
                <error-list :errors="errors.price_pence"/>
            </form>
        </td>
        <td>
            <button
                @click="storeProduct"
            >
                Store
            </button>
            <product-delete
                :product="product"
                @delete="$emit('delete')"
            ></product-delete>
        </td>
    </tr>
</template>
<script>
import ErrorList from '../ErrorList.vue';
import ProductDelete from './ProductDelete.vue';

export default {
    name: 'product-row-edit',
    components: {
        ErrorList,
        ProductDelete,
    },
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            productName: '',
            pricePounds: '0.00',
            errors: [],
        }
    },
    watch: {
        product: function() {
            this.initFromProduct();
        }
    },
    methods: {
        async storeProduct() {
            try {
                const pricePence = this.pricePounds * 100;
                await axios.patch(`/api/products/${this.product.id}`, {
                    'name': this.productName,
                    'price_pence': pricePence,
                });

                // patch was accepted
                this.errors = [];
                this.$emit('update', this.product.id, this.productName, pricePence);
            } catch (error) {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error(error);
                }
            }
        },
        initFromProduct() {
            this.productName = this.product.name;
            this.pricePounds = (this.product.price_pence * 0.01).toFixed(2);
            this.errors = [];
        }
    },
    mounted() {
        this.initFromProduct();
    }
}
</script>