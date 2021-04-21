<template>
    <div class="quote-edit">
        <h1>Edit Quote</h1>
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
            <button>Save</button>
        </form>
    </div>
</template>
<script>
import ErrorList from '../components/ErrorList.vue';

export default {
    name: 'quote-edit',
    components: {
        ErrorList,
    },
    data() {
        return {
            id: this.$route.params.id,
            customerName: '',
            customerEmail: '',
            errors: {},
        }
    },
    methods: {
        getDetails() {
            axios.get(`/api/quote/${this.id}`).then((response) => {
                this.customerName = response.data.customer_name;
                this.customerEmail = response.data.customer_email;
            }).catch((error) => {
                console.error(error);
            });
        },
        formSubmit() {
            axios.patch(`/api/quote/${this.id}`, {
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
    },
    mounted() {
        this.getDetails();
    }
}
</script>
