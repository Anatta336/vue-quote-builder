<template>
    <tr>
        <td>
            {{ product.name }}
        </td>
        <td>
            <price-from-pence :pence="product.price_pence" />
        </td>
        <td>
            <button @click="editProduct">Edit</button>
            <button class="danger" @click="deleteProduct">Delete</button>
        </td>
    </tr>
</template>
<script>
import PriceFromPence from '../PriceFromPence.vue';

export default {
    name: 'product-row-view',
    components: {
        PriceFromPence,
    },
    props: {
        product: {
            type: Object,
            required: true,
        }
    },
    methods: {
        editProduct() {
            this.$emit('edit');
        },
        deleteProduct() {
            this.$emit('delete');
        }
    }
}
</script>