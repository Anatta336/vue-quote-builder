<template>
    <div class="w-full">
        <header>
            <nav class="
                flex
                w-full
                justify-center
                gap-6
                pt-6
            ">
                <router-link
                    :to="{ name: 'products.index' }"
                    class="
                        bg-blue-400
                        p-2
                        rounded-sm
                        border-orange-300
                    "
                    active-class="border-b-4"
                >
                Products
                </router-link>
                <router-link
                    :to="{ name: 'quotes.index' }"
                    class="
                        bg-blue-400
                        p-2
                        rounded-sm
                        border-orange-300
                    "
                    active-class="border-b-4"
                >
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
