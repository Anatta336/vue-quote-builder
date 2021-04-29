<template>
    <calculate-totals
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
    </calculate-totals>
</template>
<script>
import calculateTotals from './calculateTotals.js';

export default {
    name: 'quote-totals',
    components: {
        calculateTotals,
    },
    props: {
        productsInQuote: {
            type: Array,
            required: true,
            validator(value) {
                return value.every((product) => {
                    return product.hasOwnProperty('id')
                        && product.hasOwnProperty('name')
                        && product.hasOwnProperty('price_pence')
                        && product.hasOwnProperty('count');
                });
            },
        },
        vatRate: {
            type: Number,
            default: 0.2,
            validator(value) {
                return value >= 0;
            }
        },
    }
}
</script>
