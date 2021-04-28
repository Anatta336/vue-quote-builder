<template>
<div class="counter">
    <button @click="increase">+</button>
    <slot :count="count">
        {{ count }}
    </slot>
    <button @click="decrease">-</button>
</div>
</template>
<script>
export default {
    name: 'item-counter',
    props: {
        initialCount: {
            type: [Number, String],
            default: 0,
        },
        min: {
            type: Number,
            default: 0,
        },
        max: {
            type: Number,
            default: Number.MAX_SAFE_INTEGER,
        },
    },
    data() {
        return {
            count: parseInt(this.initialCount),
        }
    },
    emits: [
        'change-count', // (newValue, oldValue)
    ],
    methods: {
        increase() {
            const old = this.count;
            this.count = Math.min(this.max, this.count + 1);
            this.$emit('change-count', this.count, old);
        },
        decrease() {
            const old = this.count;
            this.count = Math.max(this.min, this.count - 1);
            this.$emit('change-count', this.count, old);
        }
    },
    beforeUpdate() {
        this.count = parseInt(this.initialCount);
    }
}
</script>
