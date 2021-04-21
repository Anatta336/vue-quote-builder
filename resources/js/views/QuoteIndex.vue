<template>
    <div class="quote-index">
        <!-- TODO: remove me, just testing -->
        <form @submit.prevent="formSubmit">
            <label>
                Product ID
                <input v-model="productId" type="number">
            </label>
            <label>
                Count
                <input v-model="count" type="number">
            </label>
            <button>Add</button>
        </form>
    </div>
</template>
<script>

export default {
    components: {

    },
    data() {
        return {
            productId: 2,
            count: 1,
        }
    },
    methods: {
        formSubmit() {
            axios.post('/api/quote/2', {
                    'product_id': this.productId,
                    'count': this.count,
                }
            ).then((response) => {
                console.log(response);
            }).catch((error) => {
                console.error(error);
            });
        }
    }
}
</script>
