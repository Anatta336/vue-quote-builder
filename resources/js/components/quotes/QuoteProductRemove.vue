<template>
    <button class="danger" @click="remove">Remove</button>
</template>
<script>
export default {
    name: 'quote-product-remove',
    props: {
        quoteId: {
            type: Number,
            required: true,
        },
        productId: {
            type: Number,
            required: true,
        },
    },
    emits: [
        'remove-begin',
        'remove-success',
        'remove-error',
    ],
    methods: {
        async remove() {
            this.$emit('remove-begin');
            try {
                await axios.delete(`/api/quotes/${this.quoteId}/products/${this.productId}`);
                this.$emit('remove-success');
            } catch (error) {
                console.warn(error);
                this.$emit('remove-error');
            }
        }
    }
}
</script>
