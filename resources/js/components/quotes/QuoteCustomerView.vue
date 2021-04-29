<template>
    <div class="quote-customer-view">
        <p>
            Customer Name: {{ quote.customer_name }}
        </p>
        <p>
            Customer Email: {{ quote.customer_email }}
        </p>
    </div>
</template>
<script>
export default {
    name: 'quote-customer-view',
    props: {
        quote: {
            type: Object,
            required: true,
            validator(value) {
                return value.hasOwnProperty('id')
                    && value.hasOwnProperty('customer_name')
                    && value.hasOwnProperty('customer_email');
            },
        }
    },
}
</script>