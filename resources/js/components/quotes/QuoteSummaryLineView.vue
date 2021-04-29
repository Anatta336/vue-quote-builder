<template>
<tr>
    <td>{{ quote.customer_name }}</td>
    <td>{{ quote.customer_email }}</td>
    <td>
        <router-link
            class="button"
            :to="{
                name: 'quotes.view',
                params: { id: quote.id }
            }"
        >
            View
        </router-link>

        <router-link
            class="button"
            :to="{
                name: 'quotes.edit',
                params: { id: quote.id }
            }"
        >
            Edit
        </router-link>

        <quote-delete
            :quote="quote"
            @delete-begin="$emit('delete-begin', quote)"
            @delete-success="$emit('delete-success', quote)"
            @delete-error="$emit('delete-error', quote)"
        ></quote-delete>
    </td>
</tr>
</template>
<script>
import QuoteDelete from './QuoteDelete.vue'
export default {
  components: { QuoteDelete },
    name: 'quote-summary-line-view',
    props: {
        quote: {
            type: Object,
            required: true,
            validator(value) {
                return value.hasOwnProperty('id')
                    && value.hasOwnProperty('customer_name')
                    && value.hasOwnProperty('customer_email');
            },
        },
    },
    emits: [
        'delete-begin',
        'delete-success',
        'delete-error',
    ],
}
</script>