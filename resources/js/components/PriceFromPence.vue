<template>
    <span class="money">£{{ (pence / 100).toFixed(2) }}</span>
</template>
<script>
export default {
    name: 'price-from-pence',
    props: {
        pence: [String, Number],
    }
}
</script>
