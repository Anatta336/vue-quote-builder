<template>
    <div>
        <header>
            <nav>
                <router-link :to="{ name: 'products.index' }">
                Products
                </router-link>
                <router-link :to="{ name: 'quotes.index' }">
                Quotes
                </router-link>
            </nav>
        </header>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
