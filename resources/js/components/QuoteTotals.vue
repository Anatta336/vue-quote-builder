<template>
    <div class="totals">
        <div>
            Subtotal: <price-from-pence :pence="subTotal" />
        </div>
        <div>
            VAT: <price-from-pence :pence="vatTotal" />
        </div>
        <div class="grand-total">
            Grand Total: <price-from-pence :pence="grandTotal" />
        </div>
    </div>
</template>
<script>
import PriceFromPence from './PriceFromPence.vue';

export default {
    name: 'quote-totals',
    components: {
        PriceFromPence,
    },
    props: {
        productsInQuote: {
            type: Array,
            required: true,
        },
        vatRate: {
            type: Number,
            required: true,
        },
    },
    computed: {
        subTotal: function() {
            return this.productsInQuote.reduce((sum, product) => {
                return sum + product.price_pence * product.count;
            }, 0)
        },
        vatTotal: function() {
            return this.subTotal * this.vatRate;
        },
        grandTotal: function() {
            return this.subTotal + this.vatTotal;
        }
    }
}
</script>
