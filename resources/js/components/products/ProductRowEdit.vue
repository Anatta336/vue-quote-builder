<template>
    <tr class="h-10">
        <td class="p-2"
            style="text-align: left; vertical-align: middle;"
        >
            <form class="m-0" @submit.prevent="storeProduct">
                <input
                    v-model="productName"
                    type="text"
                    class="p-2 bg-blue-100 w-full"
                >
                <error-list :errors="errors.name"/>
            </form>
        </td>
        <td class="p-2"
            style="text-align: center; vertical-align: middle;"
        >
            <form class="m-0" @submit.prevent="storeProduct">
                £<input
                    v-model="pricePounds"
                    type="text"
                    class="p-2 w-16 bg-blue-100"
                >
                <error-list :errors="errors.price_pence"/>
            </form>
        </td>
        <td class="p-2"
            style="text-align: center; vertical-align: middle;"
        >
            <button
                @click="storeProduct"
                class="p-2 rounded-sm bg-green-400"
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
            validator(value) {
                return value.hasOwnProperty('id')
                    && value.hasOwnProperty('name')
                    && value.hasOwnProperty('price_pence');
            },
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
        product() {
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
                    console.warn(error);
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