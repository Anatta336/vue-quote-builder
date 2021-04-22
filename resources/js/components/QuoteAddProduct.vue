<template>
    <tr>
        <td>
            <select v-model="product">
                <option :value="null">
                    ----
                </option>
                <option v-for="product in productsCouldAdd" :key="product.id" :value="product">
                    {{ product.name }}
                </option>
            </select>
        </td>
        <td class="count"><div>
            <input v-model="count" type="number" min="1" step="1">
        </div></td>
        <td>
            <price-from-pence class="preview" :pence="linePrice"/>
        </td>
        <td>
            <button :disabled="!product" @click="addProduct">
                Add
            </button>
        </td>
    </tr>
</template>
<script>
import PriceFromPence from './PriceFromPence.vue'

export default {
    name: 'quote-add-product',
    components: {
        PriceFromPence,
    },
    props: {
        allProducts: {
            type: Array,
            required: true,
        },
        productsInQuote: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            product: null,
            count: 1,
        };
    },
    computed: {
        linePrice: function() {
            if (!this.product) {
                return 0;
            }
            return this.product.price_pence * this.count;
        },
        productsCouldAdd: function() {
            return this.allProducts.filter((product) => {
                return !this.productsInQuote.some((inQuote) => {
                    return product.id === inQuote.product_id;
                });
            });
        }
    },
    watch: {
        count: function(value) {
            // force to be integer
            value = Math.round(value);

            // force to be positive
            if (value < 1) {
                value = 1;
            }

            this.count = value;
        }
    },
    methods: {
        addProduct: function() {
            if (!this.product) {
                return;
            }

            // send event
            this.$emit('addProduct', this.product, this.count);

            // reset form
            this.product = null;
            this.count = 1;
        },
    }
}
</script>