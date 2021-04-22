<template>
    <ul v-if="errors" class="error">
        <li class="error" v-for="(error, index) in errors" :key="index">
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