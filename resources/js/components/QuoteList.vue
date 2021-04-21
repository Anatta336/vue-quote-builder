<template>
    <table>
        <tr>
            <th>Customer</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <tr v-if="!quotes">
            <th>No quotes found.</th>
        </tr>
        <tr v-for="quote in quotes" :key="quote.id">
            <td>{{ quote.customer_name }}</td>
            <td>{{ quote.customer_email }}</td>
            <td>
                <button @click="editQuote(quote)">Edit Customer</button>
                <button @click="editQuoteProducts(quote)">Edit Products</button>
                <button class="danger" @click="deleteQuote(quote)">Delete</button>
            </td>
        </tr>
    </table>
</template>
<script>
export default {
    name: "quote-list",
    data() {
        return {
            quotes: [],
        };
    },
    methods: {
        getQuotes() {
            axios.get('/api/quotes').then((response) => {
                this.quotes = response.data;
            }).catch((error) => {
                console.error(error);
            });
        },
        editQuote(quote) {
            this.$router.push({
                name: 'quotes.edit',
                params: {
                    id: quote.id,
                },
            });
        },
        editQuoteProducts(quote) {
            this.$router.push({
                name: 'quoteProducts.edit',
                params: {
                    id: quote.id,
                },
            });
        },
        deleteQuote(quote) {
            //TODO: confirm deletion

            axios.delete(`/api/quotes/${quote.id}`).then((response) => {
                // refresh list of quotes as it should have changed
                this.getQuotes();
            }).catch((error) => {
                console.error(error);
            });
        },
    },
    mounted() {
        this.getQuotes();
    }
}
</script>
