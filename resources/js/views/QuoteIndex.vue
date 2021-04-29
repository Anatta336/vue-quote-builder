<template>
    <div class="quote-index">
        <quote-summary-table
            :quotes="quotes"
        >
            <template #default="{ quote }">
                <quote-summary-line-view
                    :quote="quote"
                    @delete-begin="quoteDeleted(quote)"
                    @delete-error="fetchQuotes()"
                ></quote-summary-line-view>
            </template>

            <template #after-loop>
                <quote-summary-line-add
                    @create-success="quoteCreated()"
                ></quote-summary-line-add>
            </template>
        </quote-summary-table>
    </div>
</template>
<script>
import QuoteSummaryTable from '../components/quotes/QuoteSummaryTable.vue';
import QuoteSummaryLineView from '../components/quotes/QuoteSummaryLineView.vue';
import QuoteSummaryLineAdd from '../components/quotes/QuoteSummaryLineAdd.vue';

export default {
    name: 'quote-index',
    components: {
        QuoteSummaryTable,
        QuoteSummaryLineView,
        QuoteSummaryLineAdd,
    },
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
                console.warn(error);
            }
        },
        quoteDeleted(toRemove) {
            // remove from local list
            this.quotes = this.quotes.filter((quote) => quote.id !== toRemove.id);
        },
        quoteCreated() {
            this.fetchQuotes();
        }
    },
    mounted() {
        this.fetchQuotes();
    }
}
</script>
