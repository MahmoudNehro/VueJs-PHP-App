import { createRouter, createWebHistory } from 'vue-router'
import ProductListView from '../views/ProductListView.vue'
import AddProductView from '../views/AddProductView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'product-list',
      component: ProductListView
    },
    {
      path: '/add-product',
      name: 'add-product',
      component: AddProductView
    }
  ]
})

export default router
