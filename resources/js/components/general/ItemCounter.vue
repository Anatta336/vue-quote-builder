<template>
<div class="counter">
    <button @click="increase">+</button>
    <slot>
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
        }
    },
    data() {
        return {
            count: parseInt(this.initialCount),
        }
    },
    emits: [
        'change-count',
    ],
    methods: {
        increase() {
            this.count++;
            this.$emit('change-count', this.count);
        },
        decrease() {
            this.count = Math.max(0, this.count - 1);
            this.$emit('change-count', this.count);
        }
    },
    beforeUpdate() {
        this.count = this.initialCount;
    }
}
</script>
