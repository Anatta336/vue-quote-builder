<template>
    <form @submit.prevent="saveCustomer">
            <div>
                <label>
                    Customer Name
                    <input v-model="quote.customer_name" type="text">
                </label>
                <error-list v-if="errors" :errors="errors.customer_name"/>
            </div>
            <div>
                <label>
                    Customer Email
                    <input v-model="quote.customer_email" type="email">
                </label>
                <error-list v-if="errors" :errors="errors.customer_email"/>
            </div>
            <button>Update Customer</button>
        </form>
</template>
<script>
import ErrorList from './ErrorList.vue';

export default {
    name: 'quote-customer-edit',
    components: {
        ErrorList,
    },
    props: {
        quote: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            errors: [],
        }
    },
    methods: {
        async saveCustomer() {
            try {
                await axios.patch(`/api/quotes/${this.quote.id}`, {
                    'customer_name': this.quote.customer_name,
                    'customer_email': this.quote.customer_email,
                });
            } catch(error) {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
}
</script>