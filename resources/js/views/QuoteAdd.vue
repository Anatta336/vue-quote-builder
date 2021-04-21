<template>
    <div class="quote-add">
        <h1>Create Quote</h1>
        <form @submit.prevent="formSubmit">
            <div>
                <label>
                    Customer Name
                    <input v-model="customerName" type="text">
                </label>
                <error-list v-if="errors" :errors="errors['customer_name']"/>
            </div>
            <div>
                <label>
                    Customer Email
                    <input v-model="customerEmail" type="email">
                </label>
                <error-list v-if="errors" :errors="errors['customer_email']"/>
            </div>
            <button>Create</button>
        </form>
    </div>
</template>
<script>
import ErrorList from '../components/ErrorList.vue';

export default {
    name: 'quote-add',
    components: {
        ErrorList,
    },
    data() {
        return {
            customerName: '',
            customerEmail: '',
            errors: {},
        }
    },
    methods: {
        formSubmit() {
            axios.post('/api/quotes', {
                    'customer_name': this.customerName,
                    'customer_email': this.customerEmail,
                }
            ).then(() => {
                //TODO: display a "quote added" message?

                // redirect to the quote index route
                this.$router.push({ name: 'quote.index' });
            }).catch((error) => {
                if (error?.response?.data?.errors) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>
