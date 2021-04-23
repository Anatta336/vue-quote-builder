<template>
<tr>
    <td>
        {{ product.name }}
    </td>
    <td class="count">
        <span class="count">{{ localCount }}</span>
    </td>
    <td>
        <price-from-pence :pence="line_price"/>
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
        line_price: function() {
            return this.product.price_pence * this.localCount;
        }
    },
}
</script>