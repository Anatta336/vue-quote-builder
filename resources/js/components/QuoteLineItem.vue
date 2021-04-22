<template>
<tr>
    <td>{{ name }}</td>
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
        product_id: [String, Number],
        name: String,
        count: [String, Number],
        price_pence: [String, Number],
    },
    data() {
        return {
            localCount: this.count,
        };
    },
    computed: {
        line_price: function() {
            return this.price_pence * this.localCount;
        }
    },
    methods: {
        increaseCount: function() {
            this.localCount++;
            this.$emit('change-count', this.product_id, this.localCount);
        },
        decreaseCount: function() {
            this.localCount = Math.max(0, this.localCount - 1);
            this.$emit('change-count', this.product_id, this.localCount);
        },
        remove: function() {
            this.$emit('remove', this.product_id);
        }
    }
}
</script>