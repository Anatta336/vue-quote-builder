<template>
<tr>
    <td>
        {{ product.name }}
    </td>
    <td class="count">
        <span class="count">{{ localCount }}</span>
    </td>
    <td>
        <span class="money">
            {{ linePrice | penceAsPounds }}
        </span>
    </td>
</tr>
</template>
<script>
import PriceFromPence from './PriceFromPence.vue';

export default {
    name: 'quote-line-item-view',
    components: {
        PriceFromPence,
    },
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            localCount: this.product.count,
        };
    },
    computed: {
        linePrice: function() {
            return this.product.price_pence * this.localCount;
        }
    },
}
</script>