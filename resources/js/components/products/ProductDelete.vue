<template>
    <button class="danger" @click="deleteProduct">
        <slot>
            Delete
        </slot>
    </button>
</template>
<script>
export default {
    name: 'product-delete',
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    emits: [
        'delete-begin',
        'delete-success',
        'delete-error',
    ],
    methods: {
        async deleteProduct() {
            this.$emit('delete-begin');
            try {
                await axios.delete(`/api/products/${this.product.id}`);
                this.$emit('delete-success');
            } catch(error) {
                console.warn(error);
                this.$emit('delete-error');
            }
        }
    }
}
</script>
