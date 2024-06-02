import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home',
      name: 'home',
      component: () => import('../modules/home/views/Home.vue')
    },
    {
      path: '/move_bank',
      name: 'MoveBank',
      component: () => import('../modules/account/views/MoveBank.vue')
    },
    {
      path: '/balance',
      name: 'SearchClient',
      component: () => import('../modules/account/views/Balance.vue')
    },
    {
      path: '/register',
      name: 'NewUser',
      component: () => import('../modules/client/views/NewCli.vue')
    },
    {
      path: '/close_account',
      name: 'InaClient',
      component: () => import('../modules/client/views/InaCli.vue')
    }
  ]
})

export default router
