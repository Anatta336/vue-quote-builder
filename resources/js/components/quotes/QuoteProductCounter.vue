<template>
    <item-counter
        :initialCount="product.count"
        @change-count="(newValue, oldValue) => changeCount(newValue, oldValue)"
        v-slot:default="{ count }"
    >
        <slot :count="count">
            ×{{ count }}
        </slot>
    </item-counter>
</template>
<script>
import ItemCounter from '../general/ItemCounter.vue';

export default {
    name: 'quote-product-counter',
    props: {
        quoteId: {
            type: Number,
            required: true,
        },
        product: {
            type: Object,
            required: true,
            validator(value) {
                return value.hasOwnProperty('id')
                    && value.hasOwnProperty('name')
                    && value.hasOwnProperty('price_pence')
                    && value.hasOwnProperty('count');
            },
        },
    },
    components: {
        ItemCounter,
    },
    emits: [
        'change-begin',   // (newValue, oldValue)
        'change-success', // (newValue, oldValue)
        'change-error',   // (newValue, oldValue)
    ],
    methods: {
        async changeCount(newValue, oldValue) {
            this.$emit('change-begin', newValue, oldValue);
            try {
                await axios.patch(
                    `/api/quotes/${this.quoteId}/products/${this.product.id}`,
                    { 'count': newValue }
                );
                this.$emit('change-success', newValue, oldValue);
            } catch (error) {
                console.warn(error);
                this.$emit('change-error', newValue, oldValue);
            }
        }
    }
}
</script>
