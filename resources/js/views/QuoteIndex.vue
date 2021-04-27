<template>
    <div class="quote-index">
        <quote-summary-table
            :quotes="quotes"
        >
            <template #default="{ quote }">
                <quote-summary-line-view
                    :quote="quote"
                    @delete-begin="quoteDeleted(quote)"
                    @delete-error="quoteNotDeleted(quote)"
                ></quote-summary-line-view>
            </template>

            <template #after-loop>
                <quote-summary-line-add
                    @create-complete="quoteCreated()"
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
                console.error(error);
            }
        },
        quoteDeleted(toRemove) {
            // remove from local list
            this.quotes = this.quotes.filter((quote) => quote.id !== toRemove.id);
        },
        quoteNotDeleted() {
            // called when a quote deletion began, but then AJAX encountered an error.
            // local list is likely to be out of sync with backend, so re-fetch
            this.fetchQuotes();
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
