<template>
    <div>
        <div class="input-group">
            <label for="size">Size (MB)</label>
            <input type="number" id="size" :value="size" @input="sizeValidation" />
            <span v-if="sizeError" class="error">{{ sizeError }}</span>
        </div>
        <span class="description">Please, provide size</span>
    </div>
</template>

<script>
export default {
    props: {
        size: Number
    },
    data() {
        return {
            sizeError: '',
        };
    },
    methods: {
        sizeValidation(event) {
            const value = parseInt(event.target.value) || 0;
            this.$emit('update:size', value);
            this.validateSize(value);
        },
        validateSize(value) {
            if (value <= 0) {
                this.sizeError = "*Please enter a valid size";
                this.$emit('update:validation-status', false);
            } else {
                this.sizeError = "";
                this.$emit('update:validation-status', true);
            }
        }
    }
}
</script>
