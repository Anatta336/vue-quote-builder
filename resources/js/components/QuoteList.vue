<template>
    <table>
        <tr>
            <th>Customer</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <tr v-if="!quotes">
            <td>No quotes found.</td>
        </tr>
        <tr v-for="quote in quotes" :key="quote.id">
            <td>{{ quote.customer_name }}</td>
            <td>{{ quote.customer_email }}</td>
            <td>
                <button @click="editQuote(quote)">Edit</button>
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
        async fetchQuotes() {
            try {
                const response = await axios.get('/api/quotes');
                this.quotes = response.data;
            } catch(error) {
                console.error(error);
            }
        },
        editQuote(quote) {
            this.$router.push({
                name: 'quotes.edit',
                params: {
                    id: quote.id,
                },
            });
        },
        async deleteQuote(toRemove) {
            // remove from local list
            this.quotes = this.quotes.filter((quote) => quote.id !== toRemove.id);

            // also remove on backend
            try {
                await axios.delete(`/api/quotes/${toRemove.id}`);
            } catch (error) {
                console.error(error);
            }
        },
    },
    mounted() {
        this.fetchQuotes();
    }
}
</script>
