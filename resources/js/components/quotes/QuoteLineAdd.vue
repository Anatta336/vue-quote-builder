<template>
    <tr>
        <td>
            <v-select
                :options="allProducts"
                label="name"
                v-model="product"
                :selectable="(option) => isSelectable(option)"
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
        quoteId: {
            type: Number,
            required: true,
            validator(value) {
                return isInteger(value) && value >= 0;
            }
        },
        allProducts: {
            type: Array,
            required: true,
            validator(value) {
                return value.every((product) => {
                    return product.hasOwnProperty('id')
                        && product.hasOwnProperty('name')
                        && product.hasOwnProperty('price_pence');
                });
            },
        },
        productsInQuote: {
            type: Array,
            required: true,
            validator(value) {
                return value.every((product) => {
                    return product.hasOwnProperty('id')
                        && product.hasOwnProperty('name')
                        && product.hasOwnProperty('price_pence')
                        && product.hasOwnProperty('count');
                });
            },
        },
    },
    data() {
        return {
            product: null,
            count: 1,
        };
    },
    computed: {
        linePrice() {
            if (!this.product) {
                return 0;
            }
            return this.product.price_pence * this.count;
        },
    },
    watch: {
        count(value) {
            // force to be integer >= 1
            value = Math.max(1, Math.round(value));
            this.count = value;
        },
        product(value) {
            // this shouldn't ever happen, but there's at least one bug in vue-select that
            // allows selecting an unselectable item. If that happens, unselect it.
            if (!this.isSelectable(value)) {
                this.product = null;
            }
        }
    },
    emits: [
        'add-product-begin',   // (product, count)
        'add-product-success', // (product, count)
        'add-product-error',   // (product, count)
    ],
    methods: {
        async addProduct() {
            if (!this.product) {
                return;
            }

            const productToAdd = this.product;
            const countToAdd = this.count;

            // reset form
            this.product = null;
            this.count = 1;

            this.$emit('add-product-begin', productToAdd, countToAdd);
            try {
                // request to add the product on backend
                await axios.post(`/api/quotes/${this.quoteId}/products/${productToAdd.id}`, {
                    'count': countToAdd,
                });
                this.$emit('add-product-success', productToAdd, countToAdd);
            } catch (error) {
                console.warn(error);
                this.$emit('add-product-error', productToAdd, countToAdd);
            }
        },
        isSelectable(product) {
            return product
                && !(this.productsInQuote.some((inQuote) => product.id === inQuote.id));
        }
    }
}
</script>