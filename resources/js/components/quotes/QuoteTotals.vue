<template>
    <totals
        :productsInQuote="productsInQuote"
        :vatRate="vatRate"
        v-slot:default="{ subTotal, vatTotal, grandTotal }"
    >
        <div class="totals">
            <div>
                Subtotal:
                <span class="money">
                    {{ subTotal | penceAsPounds }}
                </span>
            </div>
            <div>
                VAT:
                <span class="money">
                    {{ vatTotal | penceAsPounds }}
                </span>
            </div>
            <div class="grand-total">
                Grand Total:
                <span class="money">
                    {{ grandTotal | penceAsPounds }}
                </span>
            </div>
        </div>
    </totals>
</template>
<script>
import totals from './totals.js';

export default {
    name: 'quote-totals',
    components: {
        totals,
    },
    props: {
        productsInQuote: {
            type: Array,
            required: true,
        },
        vatRate: {
            type: Number,
            default: 0.2,
        },
    }
}
</script>
