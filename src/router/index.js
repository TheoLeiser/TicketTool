import Vue from 'vue'
import VueRouter from 'vue-router'
import Tickets from '../views/Tickets.vue'
import Login from '../views/Login.vue'
import { store } from '../store'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login
  },
  {
    path: '/tickets',
    name: 'Tickets',
    component: Tickets
  }
]

const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {
  if (to.fullPath === '/tickets') {
    if (!store.id) {
      next('/')
    }
  }
  if (to.fullPath === '/') {
    if (store.id) {
      next(from)
    }
  }
  next()
})

export default router
