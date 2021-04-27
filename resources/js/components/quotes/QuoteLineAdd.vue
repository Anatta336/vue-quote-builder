<template>
    <tr>
        <td>
            <!-- vanilla HTML option element
            <select v-model="product">
                <option :value="null">
                    ----
                </option>
                <option v-for="product in productsCouldAdd" :key="product.id" :value="product">
                    {{ product.name }}
                </option>
            </select>
             -->
            <v-select
                :options="allProducts"
                label="name"
                v-model="product"
                :selectable="(option) => !(productsInQuote.some((inQuote) => option.id === inQuote.product_id))"
            ></v-select>
        </td>
        <td class="count"><div>
            <input v-model="count" type="number" min="1" step="1">
        </div></td>
        <td>
            <span class="money preview">
                {{ linePrice | penceAsPounds }}
            </span>
        </td>
        <td>
            <button :disabled="!product" @click="addProduct">
                Add
            </button>
        </td>
    </tr>
</template>
<script>
export default {
    name: 'quote-line-add',
    components: {},
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
        /* as used by vanilla Select element
        productsCouldAdd: function() {
            return this.allProducts.filter((product) => {
                return !this.productsInQuote.some((inQuote) => {
                    return product.id === inQuote.product_id;
                });
            });
        }
        */
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