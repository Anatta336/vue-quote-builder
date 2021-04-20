<template>
    <ul v-if="errors" class="errors">
        <li v-for="(error, index) in errors" :key="index">
            {{ error }}
        </li>
    </ul>
</template>
<script>
export default {
    name: "error-list",
    props: {
        errors: {
            type: Array,
            required: false,
        }
    },
}
</script>