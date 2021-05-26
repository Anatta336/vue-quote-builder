<template>
    <tr class="h-10">
        <td class="p-2"
            style="text-align: left; vertical-align: middle;"
        >
            {{ product.name }}
        </td>
        <td class="p-2"
            style="text-align: center; vertical-align: middle;"
        >
            <span class="money">
                {{ product.price_pence | penceAsPounds }}
            </span>
        </td>
        <td class="p-2"
            style="text-align: center; vertical-align: middle;"
        >
            <button
                @click="$emit('edit')"
                class="
                    bg-yellow-300
                    rounded-sm
                    p-2
                "
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
            validator(value) {
                return value.hasOwnProperty('id')
                    && value.hasOwnProperty('name')
                    && value.hasOwnProperty('price_pence');
            },
        }
    },
}
</script>