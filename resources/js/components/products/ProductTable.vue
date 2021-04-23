<template>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <tr v-if="!products">
            <td>
                <slot name="empty">
                    No products found.
                </slot>
            </td>
        </tr>
        <tr v-for="product in products" :key="product.id">
            <slot
                name="product-edit"
                v-if="toEdit && toEdit.id === product.id"
                v-bind:product="product"
            ></slot>
            <slot
                name="product-view"
                v-else
                v-bind:product="product"
            >
            </slot>
        </tr>
        <slot name="after-table-rows"></slot>
    </table>
</template>
<script>
export default {
    name: 'product-table',
    props: {
        products: {
            type: Array,
            required: true,
        },
        toEdit: {
            type: Object,
            required: false,
        },
    }
}
</script>