<template>
    <tr>
        <td>
            <form @submit.prevent="create">
            <input
                type="text"
                v-model="customerName"
                required
                placeholder="New Customer Name"
            >
            </form>
            <error-list :errors="errors.customer_name"></error-list>
        </td>
        <td>
            <form @submit.prevent="create">
            <input
                type="email"
                v-model="customerEmail"
                required
                placeholder="customer@example.com"
            >
            </form>
            <error-list :errors="errors.customer_email"></error-list>
        </td>
        <td>
            <button @click="create" :disabled="!!isAwaitingCreate">Create</button>
        </td>
    </tr>
</template>
<script>
import ErrorList from '../ErrorList.vue';

export default {
    name: 'quote-summary-line-add',
    components: {
        ErrorList,
    },
    data() {
        return {
            customerName: '',
            customerEmail: '',
            errors: [],
            isAwaitingCreate: false,
        }
    },
    emits: [
        'create-begin',
        'create-complete',
    ],
    methods: {
        async create() {
            this.isAwaitingCreate = true;
            this.$emit('create-begin');
            try {
                await axios.post('/api/quotes', {
                    'customer_name': this.customerName,
                    'customer_email': this.customerEmail,
                })
                this.$emit('create-complete', this.customerName, this.customerEmail);
                this.clearForm();
            } catch (error) {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            } finally {
                this.isAwaitingCreate = false;
            }
        },
        clearForm() {
            this.customerName = '';
            this.customerEmail = '';
            this.errors = [];
        }
    },
}
</script>