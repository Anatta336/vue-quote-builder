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

        <template v-for="quote in quotes">
            <!-- TODO: should be :key="quote.id" here, on a wrapping element which doesn't break table? -->
            <slot :quote="quote"></slot>
        </template>

        <slot name="after-loop"></slot>

    </table>
</template>
<script>
export default {
    name: 'quote-summary-table',
    props: {
        quotes: {
            type: Array,
            default: () => [],
            validator(value) {
                return value.every((quote) => {
                    return quote.hasOwnProperty('id')
                        && quote.hasOwnProperty('customer_name')
                        && quote.hasOwnProperty('customer_email');
                });
            }
        }
    }
}
</script>