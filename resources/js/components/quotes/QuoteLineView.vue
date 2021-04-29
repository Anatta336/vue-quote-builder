<template>
<tr>
    <td>
        {{ product.name }}
    </td>
    <td class="count">
        <span class="count">{{ localCount }}</span>
    </td>
    <td>
        <span class="money">
            {{ linePrice | penceAsPounds }}
        </span>
    </td>
</tr>
</template>
<script>
export default {
    name: 'quote-line-view',
    components: {},
    props: {
        product: {
            type: Object,
            required: true,
            validator(value) {
                return value.hasOwnProperty('id')
                    && value.hasOwnProperty('name')
                    && value.hasOwnProperty('price_pence')
                    && value.hasOwnProperty('count');
            }
        },
    },
    data() {
        return {
            localCount: this.product.count,
        };
    },
    computed: {
        linePrice() {
            return this.product.price_pence * this.localCount;
        }
    },
}
</script>