<template>
    <table>
        <tr>
            <th>Customer</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <tr v-if="!quotes">
            <td>No quotes found.</td>
        </tr>

        <template v-for="quote in quotes">
            <slot
                :quote="quote"
            ></slot>
        </template>

        <slot
            name="after-loop"
        ></slot>

    </table>
</template>
<script>
export default {
    name: 'quote-summary-table',
    props: {
        quotes: {
            type: Array,
            default: () => [],
        }
    }
}
</script>