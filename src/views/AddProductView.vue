<template>
    <div class="container">
        <div class="navbar">
            <h1>Product Add</h1>
            <button class="confirm-add-button" @click="createProduct">Save</button>
            <a href="/" class="cancel-button">Cancel</a>
        </div>
        <div id="product_form" class="form" @submit.prevent="createProduct">
            <div class="input-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" v-model="sku" @blur="validateSku" />
                <span v-if="skuError" class="error">{{ skuError }}</span>
            </div>
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" v-model="name" @blur="validateName" />
                <span v-if="nameError" class="error">{{ nameError }}</span>
            </div>
            <div class="input-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" v-model.number="price" @blur="validatePrice" />
                <span v-if="priceError" class="error">{{ priceError }}</span>
            </div>
            <div class="input-group">
                <label for="productType">Type</label>
                <select id="productType" v-model="productType">
                    <option value="DVD">DVD</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Book">Book</option>
                </select>
            </div>
            <AsyncComponent :key="productType" :component="productTypeComponent()" @update:size="size = $event"
                @update:weight="weight = $event" @update:height="height = $event" @update:width="width = $event"
                @update:length="length = $event" @update:validation-status="isFormValid = $event" />
        </div>
    </div>
</template>



<script>
import AsyncComponent from '../components/AsyncComponent.vue';
import axios from 'axios';

const productComponents = {
    'DVD': import('../components/DVDForm.vue').then(m => m.default),
    'Book': import('../components/BookForm.vue').then(m => m.default),
    'Furniture': import('../components/FurnitureForm.vue').then(m => m.default),
};

export default {
    data() {
        return {
            sku: '',
            name: '',
            price: 0,
            productType: 'DVD',
            size: this.size,
            height: this.height,
            width: this.width,
            length: this.length,
            weight: this.weight,
            skuError: '',
            nameError: '',
            priceError: '',
            isFormValid: false
        }
    },
    components: {
        AsyncComponent,
    },
    computed: {
        productTypeComponent() {
            return () => productComponents[this.productType];
        }
    },
    methods: {
        validateSku() {
            if (!this.sku) {
                this.skuError = "*SKU is required";
                return;
            }

            axios.get(`/api/api.php`, {
                params: { sku: this.sku }
            })
                .then(response => {
                    if (response.data.exists) {
                        this.skuError = "*SKU already exists";
                    } else {
                        this.skuError = "";
                    }
                })
                .catch(error => {
                    console.error("Error checking SKU:", error);
                    this.skuError = "*Error checking SKU";
                });
        },
        validateName() {
            if (!this.name) {
                this.nameError = "*Name is required";
            } else {
                this.nameError = "";
            }
        },
        validatePrice() {
            if (!this.price || isNaN(this.price) || this.price <= 0) {
                this.priceError = "*Please enter a valid price";
            } else {
                this.priceError = "";
            }
        },
        validateInputs() {
            this.validateSku();
            this.validateName();
            this.validatePrice();
            return !this.skuError && !this.nameError && !this.priceError;
        },
        sanitizeInput(input) {
            return input.replace(/[&<>"']/g, function (match) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                }[match];
            });
        },
        createProduct() {
            if (!this.validateInputs() || !this.isFormValid) {
                console.log("rejected");
                return;
            }
            const sanitizedSku = this.sanitizeInput(this.sku);
            const sanitizedName = this.sanitizeInput(this.name);

            axios.post('/api/api.php', {
                sku: sanitizedSku,
                name: sanitizedName,
                price: this.price,
                type: this.productType,
                size: this.size,
                weight: this.weight,
                height: this.height,
                width: this.width,
                length: this.length,
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    console.log(response.data);
                    this.$router.push('/');
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>


<style>
* {
    font-family: "Kumbh Sans", sans-serif;
    box-sizing: border-box;
}

h1 {
    flex: 1;
}

.navbar {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: flex-end;
    font-size: 1.2rem;
    gap: 2rem;
}

.confirm-add-button,
.cancel-button {
    display: flex;
    align-items: center;
    text-decoration: none;
    flex-direction: row-reverse;
    justify-content: center;
    cursor: pointer;
    background-color: #f7f7f7;
    color: black;
    border: none;
    width: 10%;
    height: 60px;
    padding: 20px 30px;
    border-radius: 5px;
    font-size: 1.2rem;
    font-family: "Kumbh Sans", sans-serif;
}

.form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 20px;
}

.input-group {
    margin-bottom: 20px;
    min-height: 60px;
    position: relative;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
}

.input-group input[type="text"],
.input-group input[type="number"],
.input-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.input-group input[type="text"]:focus,
.input-group input[type="number"]:focus,
.input-group select:focus {
    border-color: #aaa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.description {
    font-size: 14px;
    color: #666;
    margin-top: 10px;
}

.error {
    font-size: 12px;
    color: red;
    margin-top: 5px;
    position: absolute;
    left: 0;
    top: 93%;
    width: 100%;
}
</style>
