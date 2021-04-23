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
    methods: {
        async deleteProduct() {
            try {
                await axios.delete(`/api/products/${this.product.id}`);
                this.$emit('delete');
            } catch(error) {
                console.error(error);
            }
        }
    }
}
</script>
