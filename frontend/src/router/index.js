import Vue from 'vue'
import VueRouter from 'vue-router'

import { isUserLoggedIn, isAdminLoggedIn } from '@/auth/utils'
// Routes
import shop from '@/router/shop'
import admin from '@/router/admin'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    ...admin,
    ...shop,
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '*',
      redirect: 'error-404',
    },
  ],
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.authUserOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!isUserLoggedIn()) {
      next({
        name: 'user.login',
        query: { redirect: to.fullPath },
      })
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.guestUserOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (isUserLoggedIn()) {
      next({
        name: 'user.homepage',
        // query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.authAdminOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!isAdminLoggedIn()) {
      next({
        name: 'admin.login',
        query: { redirect: to.fullPath },
      })
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.guestAdminOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (isAdminLoggedIn()) {
      next({
        name: 'admin.homepage',
        // query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
