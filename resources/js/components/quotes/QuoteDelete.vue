<template>
    <button class="danger" @click="deleteQuote">
        <slot>
            Delete
        </slot>
    </button>
</template>
<script>
export default {
    name: 'quote-delete',
    props: {
        quote: {
            type: Object,
            required: true,
            validator(value) {
                return value.hasOwnProperty('id');
            },
        },
    },
    emits: [
        'delete-begin',
        'delete-success',
        'delete-error',
    ],
    methods: {
        async deleteQuote() {
            try {
                this.$emit('delete-begin');
                await axios.delete(`/api/quotes/${this.quote.id}`);
                this.$emit('delete-success');
            } catch(error) {
                console.warn(error);
                this.$emit('delete-error');
            }
        }
    }
}
</script>
