<template>
    <tr>
        <td>
            {{ product.name }}
        </td>
        <td class="count">
            <quote-product-counter
                :quoteId="quoteId"
                :product="product"
                @change-begin="(newValue, oldValue) => $emit('change-count-begin', product, newValue, oldValue)"
                @change-success="(newValue, oldValue) => $emit('change-count-success', product, newValue, oldValue)"
                @change-error="(newValue, oldValue) => $emit('change-count-error', product, newValue, oldValue)"
            ></quote-product-counter>
        </td>
        <td>
            <span class="money">
                {{ linePrice | penceAsPounds }}
            </span>
        </td>
        <td>
            <quote-product-remove
                :quoteId="quoteId"
                :productId="parseInt(product.product_id)"
                @remove-begin="$emit('remove-begin', product)"
                @remove-success="$emit('remove-success', product)"
                @remove-error="$emit('remove-error', product)"
            ></quote-product-remove>
        </td>
    </tr>
</template>
<script>
import QuoteProductCounter from './QuoteProductCounter.vue';
import QuoteProductRemove from './QuoteProductRemove.vue';

export default {
    name: 'quote-line-edit',
    components: {
        QuoteProductRemove,
        QuoteProductCounter,
    },
    props: {
        quoteId: {
            type: Number,
            required: true,
        },
        product: {
            type: Object,
            required: true,
        },
    },
    computed: {
        linePrice: function() {
            return this.product.price_pence * this.product.count;
        }
    },
    emits: [
        'change-count-begin',   // (product, newValue, oldValue)
        'change-count-success', // (product, newValue, oldValue)
        'change-count-error',   // (product, newValue, oldValue)
        'remove-begin',   // (product)
        'remove-success', // (product)
        'remove-error',   // (product)
    ],
}
</script>