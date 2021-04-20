<template>
    <div>
        <h1>Build'o'matic</h1>
        <p>
            <router-link :to="{ name: 'product.index' }">Products</router-link>
        </p>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
