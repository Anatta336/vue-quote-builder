<template>
<tr>
    <td>
        {{ product.name }}
    </td>
    <td class="count">
        <button @click="increaseCount">+</button>
        <span class="count">{{ localCount }}</span>
        <button @click="decreaseCount">-</button>
    </td>
    <td>
        <span class="money">
            {{ linePrice | penceAsPounds }}
        </span>
    </td>
    <td>
        <button class="danger" @click="remove">Remove</button>
    </td>
</tr>
</template>
<script>
export default {
    name: 'quote-line-item-edit',
    components: {},
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