<template>
    <div>
        <div class="input-group">
            <label for="weight">Weight (KG)</label>
            <input type="number" id="weight" :value="weight" @input="weightValidation" />
            <span v-if="weightError" class="error">{{ weightError }}</span>
        </div>
        <span class="description">Please, provide weight</span>
    </div>
</template>

<script>
export default {
    props: {
        weight: Number
    },
    data() {
        return {
            weightError: ''
        };
    },
    methods: {
        weightValidation(event) {
            const value = parseInt(event.target.value) || 0;
            this.$emit('update:weight', value);
            this.validateWeight(value);
        },
        validateWeight(value) {
            if (value <= 0) {
                this.weightError = "*Please enter a valid weight";
                this.$emit('update:validation-status', false);
            } else {
                this.weightError = "";
                this.$emit('update:validation-status', true);
            }
        }
    }
}
</script>