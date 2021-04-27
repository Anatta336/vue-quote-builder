<template>
    <tr>
        <td>
            {{ product.name }}
        </td>
        <td class="count">
            <item-counter
                :initialCount="product.count"
                @change-count="(updatedCount) => $emit('change-count', product, updatedCount)"
            ></item-counter>
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
import ItemCounter from '../general/ItemCounter.vue';

export default {
    name: 'quote-line-edit',
    components: {
        ItemCounter,
    },
    props: {
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
    methods: {
        remove: function() {
            this.$emit('remove', this.product);
        }
    }
}
</script>