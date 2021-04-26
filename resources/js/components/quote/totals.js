const totals = {
    render() {
        return this.$scopedSlots.default({
            subTotal: this.subTotal,
            vatTotal: this.vatTotal,
            grandTotal: this.grandTotal,
        });
    },
    props: {
        productsInQuote: {
            type: Array,
            required: true,
        },
        vatRate: {
            type: Number,
            default: 0.2,
        },
    },
    computed: {
        subTotal: function() {
            return this.productsInQuote.reduce((sum, product) => {
                return sum + product.price_pence * product.count;
            }, 0)
        },
        vatTotal: function() {
            return this.subTotal * this.vatRate;
        },
        grandTotal: function() {
            return this.subTotal + this.vatTotal;
        }
    }
};
export default totals;