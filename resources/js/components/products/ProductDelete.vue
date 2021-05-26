<template>
    <button
        @click="deleteProduct"
        class="
            bg-red-500
            rounded-sm
            p-2
        "
    >
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
            validator(value) {
                return value.hasOwnProperty('id');
            },
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
