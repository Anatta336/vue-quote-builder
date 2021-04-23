<template>
    <tr>
        <td>
            {{ product.name }}
        </td>
        <td>
            <price-from-pence :pence="product.price_pence" />
        </td>
        <td>
            <button
                @click="$emit('edit')"
            >
                Edit
            </button>
            <product-delete
                :product="product"
                @delete="$emit('delete')"
            ></product-delete>
        </td>
    </tr>
</template>
<script>
import PriceFromPence from '../PriceFromPence.vue';
import ProductDelete from './ProductDelete.vue';

export default {
    name: 'product-row-view',
    components: {
        PriceFromPence,
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