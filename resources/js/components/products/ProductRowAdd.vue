<template>
    <tr class="h-10">
        <td class="p-2"
            style="text-align: left; vertical-align: middle;"
        >
            <form class="m-0" @submit.prevent="addProduct">
                <input
                    v-model="productName"
                    type="text"
                    placeholder="New Product Name"
                    class="p-2 bg-blue-100 w-full"
                >
                <error-list :errors="errors.name"/>
            </form>
        </td>
        <td class="p-2"
            style="text-align: center; vertical-align: middle;"
        >
            <form class="m-0" @submit.prevent="addProduct">
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
                @click="addProduct"
                class="p-2 rounded-sm bg-green-400"
            >
                Add
            </button>
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