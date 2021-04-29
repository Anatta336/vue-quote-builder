const fetchQuote = {
    render() {
        return this.$scopedSlots.default({
            fetchQuote: this.fetchQuote,
            fetchAllProducts: this.fetchAllProducts,
            fetchProductsInQuote: this.fetchProductsInQuote,
            quote: this.quote,
            allProducts: this.allProducts,
            productsInQuote: this.productsInQuote,
            addProductToLocal: this.addProductToLocal,
            changeCountInLocal: this.changeCountInLocal,
            removeProductFromLocal: this.removeProductFromLocal,
        });
    },
    data() {
        return {
            quote: null,
            allProducts: [],
            productsInQuote: [],
        }
    },
    methods: {
        async fetchQuote() {
            try {
                const response = await axios.get(`/api/quotes/${this.$route.params.id}`)
                this.quote = response.data;
            } catch (error) {
                console.warn(error);
            }
        },
        async fetchAllProducts() {
            try {
                const response = await axios.get('/api/products')
                this.allProducts = response.data;
            } catch (error) {
                console.warn(error);
            }
        },
        async fetchProductsInQuote() {
            try {
                const response = await axios.get(`/api/quotes/${this.$route.params.id}/products`);
                this.productsInQuote = response.data.map((responseProduct) => {
                    // the response has:  .product_id, .name, .price_pence, .count
                    // but want to store:         .id, .name, .price_pence, .count
                    return {
                        ...responseProduct,
                        id: responseProduct.product_id,
                        product_id: undefined,
                    };
                });
            } catch (error) {
                console.warn(error);
            }
        },
        addProductToLocal(product, count) {
            if (!product) {
                return;
            }

            this.productsInQuote.push({
                ...product,
                count,
            });
        },
        changeCountInLocal(product, newCount) {
            if (!product) {
                return;
            }

            product.count = newCount;
            if (newCount <= 0) {
                this.removeProductFromLocal(product);
            }
        },
        removeProductFromLocal(product) {
            if (!product) {
                return;
            }

            this.productsInQuote = this.productsInQuote.filter((productInQuote) => {
                return productInQuote.id !== product.id;
            });
        },
    },
    mounted() {
        this.fetchQuote();
        this.fetchAllProducts();
        this.fetchProductsInQuote();
    },
};
export default fetchQuote;
