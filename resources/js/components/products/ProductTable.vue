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
        <template v-for="product in products">
            <slot
                name="product-edit"
                v-if="idToEdit === product.id"
                v-bind:product="product"
            ></slot>
            <slot
                name="product-view"
                v-else
                v-bind:product="product"
            >
            </slot>
        </template>
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
        idToEdit: {
            type: Number,
            required: true,
        },
    }
}
</script>