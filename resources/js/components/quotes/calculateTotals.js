const calculateTotals = {
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
            validator(value) {
                return value.every((product) => {
                    return product.hasOwnProperty('id')
                        && product.hasOwnProperty('name')
                        && product.hasOwnProperty('price_pence')
                        && product.hasOwnProperty('count');
                });
            },
        },
        vatRate: {
            type: Number,
            default: 0.2,
            validator(value) {
                return value >= 0;
            }
        },
    },
    computed: {
        subTotal() {
            return this.productsInQuote.reduce((sum, product) => {
                return sum + product.price_pence * product.count;
            }, 0)
        },
        vatTotal() {
            return this.subTotal * this.vatRate;
        },
        grandTotal() {
            return this.subTotal + this.vatTotal;
        }
    }
};
export default calculateTotals;
