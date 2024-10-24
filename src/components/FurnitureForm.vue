<template>
    <div>
        <div class="input-group">
            <label for="height">Height (CM)</label>
            <input type="number" id="height" :value="height" @input="validateInput('height', $event)" />
            <span v-if="heightError" class="error">{{ heightError }}</span>
        </div>
        <div class="input-group">
            <label for="width">Width (CM)</label>
            <input type="number" id="width" :value="width" @input="validateInput('width', $event)" />
            <span v-if="widthError" class="error">{{ widthError }}</span>
        </div>
        <div class="input-group">
            <label for="length">Length (CM)</label>
            <input type="number" id="length" :value="length" @input="validateInput('length', $event)" />
            <span v-if="lengthError" class="error">{{ lengthError }}</span>
            <span class="description">Please, provide dimensions</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        height: Number,
        width: Number,
        length: Number
    },
    data() {
        return {
            heightError: '',
            widthError: '',
            lengthError: ''
        };
    },
    methods: {
        validateInput(type, event) {
            const value = parseInt(event.target.value) || 0;
            console.log(value);
            this.$emit(`update:${type}`, value);
            this[`validate${type.charAt(0).toUpperCase() + type.slice(1)}`](value);
        },
        validateHeight(value) {
            this.heightError = value <= 0 ? "*Please enter a valid height" : "";
            this.$emit('update:validation-status', value > 0);
        },
        validateWidth(value) {
            this.widthError = value <= 0 ? "*Please enter a valid width" : "";
            this.$emit('update:validation-status', value > 0);
        },
        validateLength(value) {
            this.lengthError = value <= 0 ? "*Please enter a valid Length" : "";
            this.$emit('update:validation-status', value > 0);
        }
    }
}
</script>
