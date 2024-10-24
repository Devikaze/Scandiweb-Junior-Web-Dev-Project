<template>
  <label class="product-item">
    <input class="delele-checkbox" type="checkbox" :id="product.sku" @change="toggleSelect" />
    <div class="text-container">
      <label :for="product.sku">{{ product.sku }}</label>
      <label :for="product.sku">{{ product.name }}</label>
      <label :for="product.sku">{{ parseFloat(product.price).toFixed(2) }} $</label>
    </div>
    <div class="text-items"
      v-for="[key, value] in Object.entries(product).filter(([key]) => key !== 'id' && key !== 'sku' && key !== 'name' && key !== 'price')"
      :key="key">
      <label v-if="value">{{ key.charAt(0).toUpperCase() + key.slice(1) }}: {{ value }}</label>
    </div>
  </label>
</template>

<script>
export default {
  props: {
    product: Object
  },
  methods: {
    toggleSelect() {
      this.$emit('select', this.product.sku);
    }
  }
}
</script>


<style scoped>
* {
  font-size: 14px;
}

.product-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 30px;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  position: relative;
  user-select: none;
}

.product-item:hover {
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

.delele-checkbox {
  position: absolute;
  top: 10px;
  left: 10px;
}

.text-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 10px;
}

.text-items {
  display: flex;
  flex-direction: column;
  align-items: center;
}

label {
  font-weight: bold;
}

span {
  font-weight: bold;
  margin-right: 10px;
}
</style>