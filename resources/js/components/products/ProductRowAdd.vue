<template>
    <tr>
        <td>
            <form @submit.prevent="addProduct">
                <input v-model="productName" type="text" placeholder="New Product Name">
                <error-list :errors="errors.name"/>
            </form>
        </td>
        <td>
            <form @submit.prevent="addProduct">
                £<input v-model="pricePounds" type="text">
                <error-list :errors="errors.price_pence"/>
            </form>
        </td>
        <td>
            <button @click="addProduct">Add</button>
        </td>
    </tr>
</template>
<script>
import ErrorList from '../ErrorList.vue';

export default {
    name: 'product-row-add',
    components: {
        ErrorList,
    },
    data() {
        return {
            productName: '',
            pricePounds: '0.00',
            errors: [],
        }
    },
    methods: {
        async addProduct() {
            try {
                const pricePence = this.pricePounds * 100;
                await axios.post('/api/products', {
                    'name': this.productName,
                    'price_pence': pricePence,
                })
                this.$emit('add', this.productName, pricePence);
                this.clearInput();
            } catch (error) {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        clearInput() {
            this.productName = '';
            this.pricePounds = '0.00';
            this.errors = [];
        }
    },
}
</script>