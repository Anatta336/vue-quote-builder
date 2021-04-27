<template>
    <tr>
        <td>
            {{ product.name }}
        </td>
        <td>
            <span class="money">
                {{ product.price_pence | penceAsPounds }}
            </span>
        </td>
        <td>
            <button
                @click="$emit('edit')"
            >
                Edit
            </button>
            <product-delete
                :product="product"
                @delete-begin="$emit('delete-begin')"
                @delete-success="$emit('delete-success')"
                @delete-error="$emit('delete-error')"
            ></product-delete>
        </td>
    </tr>
</template>
<script>
import ProductDelete from './ProductDelete.vue';

export default {
    name: 'product-row-view',
    components: {
        ProductDelete,
    },
    props: {
        product: {
            type: Object,
            required: true,
        }
    },
}
</script>