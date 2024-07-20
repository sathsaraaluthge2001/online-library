// Composables
import { createRouter, createWebHistory } from 'vue-router/auto'
import { setupLayouts } from 'virtual:generated-layouts'
import { routes as autoGeneratedRoutes } from 'vue-router/auto-routes'
import HomePage from '../components/HomePage.vue'
// Manually defined routes
const customRoutes = [
  
  {
    path: '/home',
    name: 'HomePage',
    component: HomePage
  }
]

// Merge custom routes with auto-generated routes
const routes = setupLayouts([...autoGeneratedRoutes, ...customRoutes])

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.isReady().then(() => {
  localStorage.removeItem('vuetify:dynamic-reload')
})

export default router
