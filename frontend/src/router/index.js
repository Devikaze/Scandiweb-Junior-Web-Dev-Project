import { createRouter, createWebHistory } from 'vue-router'
import ProductView from '../views/ProductView.vue';
import AddProductView from '../views/AddProductView.vue';
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name:'main',
      component: ProductView
    },
    {
      path: '/addproduct',
      name:'addproduct',
      component: AddProductView
    }
  ]
})

export default router
