<template>
<tr>
    <td>{{ product.name }}</td>
    <td class="count">
        <button @click="increaseCount">+</button>
        <span class="count">{{ localCount }}</span>
        <button @click="decreaseCount">-</button>
    </td>
    <td><price-from-pence :pence="line_price"/></td>
    <td>
        <button class="danger" @click="remove">Remove</button>
    </td>
</tr>
</template>
<script>
import PriceFromPence from './PriceFromPence.vue';

export default {
    name: 'quote-line-item',
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
    methods: {
        increaseCount: function() {
            this.localCount++;
            this.$emit('change-count', this.product, this.localCount);
        },
        decreaseCount: function() {
            this.localCount = Math.max(0, this.localCount - 1);
            this.$emit('change-count', this.product, this.localCount);
        },
        remove: function() {
            this.$emit('remove', this.product);
        }
    }
}
</script>