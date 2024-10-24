<template>

  <body>
    <div class="navbar">
      <h1 class="title">Product List</h1>
      <a href="/addproduct" class="add-button">Add</a>
      <button class="mass-delete-button" @click="massDelete">Mass Delete</button>
    </div>
    <hr>
    <div class="product-list">
      <div class="grid-container">
        <ProductItem v-for="(product, id) in filteredProducts" :key="id" :product="product" @select="toggleSelection" />
      </div>
    </div>
  </body>
</template>

<script>
import ProductItem from '../components/ProductItem.vue'
import axios from 'axios';

export default {
  components: { ProductItem },
  data() {
    return {
      products: [],
      selectedProducts: new Set()
    }
  },
  computed: {
    filteredProducts() {
      const uniqueProducts = new Set();
      return this.products.filter(product => {
        if (product && product.sku && !uniqueProducts.has(product.sku)) {
          uniqueProducts.add(product.sku);
          return true;
        }
        return false;
      });
    }
  },
  methods: {
    toggleSelection(sku) {
      if (this.selectedProducts.has(sku)) {
        this.selectedProducts.delete(sku);
      } else {
        this.selectedProducts.add(sku);
      }
    },
    massDelete() {
      const skusToDelete = Array.from(this.selectedProducts);
      axios.delete('http://localhost:8100/Scandiweb-Fullstack-Junior-Web-Dev-Project/backend/api.php', {
        data: { skus: skusToDelete }
      })
        .then(response => {
          console.log(response.data);
          this.products = this.products.filter(product => !this.selectedProducts.has(product.sku));
          this.selectedProducts.clear();
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
  mounted() {
    axios.get('http://localhost:8100/Scandiweb-Fullstack-Junior-Web-Dev-Project/backend/api.php')
      .then(response => {
        console.log(response.data);
        this.products = response.data;
      })
      .catch(error => {
        console.error(error);
      });
  }
}
</script>


<style scoped>
* {
  display: block;
  box-sizing: border-box;
  font-family: "Kumbh Sans", sans-serif;
}

.navbar {
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: flex-end;
  font-size: 1.2rem;
  gap: 2rem;
}

.title {
  flex: 1;
}

.add-button,
.mass-delete-button {
  display: flex;
  align-items: center;
  text-decoration: none;
  flex-direction: row-reverse;
  justify-content: center;
  cursor: pointer;
  background-color: #f7f7f7;
  color: black;
  width: 9%;
  height: 60px;
  padding: 20px 30px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.product-list {
  display: flex;
  align-items: center;
  justify-content: center;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 20px;
  margin-bottom: 20px;
  justify-content: space-between;
}
</style>