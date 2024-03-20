import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '', redirect: '/dashboard' },
    {
      path: '/',
      component: () => import('../layouts/default.vue'),
      children: [ 
        {
          path: 'dashboard',
          component: () => import('../pages/others/dashboard.vue'),
        },
        
        {
          path: 'account-settings',
          component: () => import('../pages/others/account-settings.vue'),
        }, 
        {
          path: 'companies',
          component: () => import('../pages/companies/list.vue'),
        }, 
        { 
          path: 'companies/edit/:id',
          component: () => import('../pages/companies/edit.vue')  
        }, 
        { 
          path: 'companies/add',
          component: () => import('../pages/companies/add.vue')  
        }, 
        { 
          path: 'companies/view/:id',
          component: () => import('../pages/companies/view.vue') 
        }, 
        {
          path: 'customers',
          component: () => import('../pages/customers/list.vue'),
        }, 
        { 
          path: 'customers/edit/:id',
          component: () => import('../pages/customers/edit.vue')  
        }, 
        { 
          path: 'customers/add',
          component: () => import('../pages/customers/add.vue')  
        }, 
        { 
          path: 'customers/view/:id',
          component: () => import('../pages/customers/view.vue') 
        }, 
        { 
          path: 'customers/log/:id',
          component: () => import('../pages/customers/log.vue') 
        }, 
        {
          path: 'staff',
          component: () => import('../pages/staff/list.vue'),
        }, 
        { 
          path: 'staff/edit/:id',
          component: () => import('../pages/staff/edit.vue')  
        }, 
        { 
          path: 'staff/add',
          component: () => import('../pages/staff/add.vue')  
        }, 
        { 
          path: 'staff/view/:id',
          component: () => import('../pages/staff/view.vue') 
        }, 
        { 
          path: 'staff/log/:id/:date?',
          component: () => import('../pages/staff/log.vue') 
        }, 
        
        {
          path: 'meeting',
          component: () => import('../pages/meeting/list.vue'),
        }, 
        { 
          path: 'meeting/edit/:id',
          component: () => import('../pages/meeting/edit.vue')  
        }, 
        { 
          path: 'meeting/add',
          component: () => import('../pages/meeting/add.vue')  
        }, 
        { 
          path: 'meeting/view/:id',
          component: () => import('../pages/meeting/view.vue') 
        }, 
        { 
          path: 'meeting/view/:id',
          component: () => import('../pages/meeting/print.vue') 
        }, 
        {
          path: 'users',
          component: () => import('../pages/users/list.vue'),
        }, 
        { 
          path: 'users/edit/:id',
          component: () => import('../pages/users/edit.vue')  
        }, 
        { 
          path: 'users/add',
          component: () => import('../pages/users/add.vue')  
        }, 
        { 
          path: 'users/view/:id',
          component: () => import('../pages/users/view.vue') 
        }, 
        {
          path: 'files',
          component: () => import('../pages/files/list.vue'),
        }, 
        { 
          path: 'files/edit/:id',
          component: () => import('../pages/files/edit.vue')  
        }, 
        { 
          path: 'files/add',
          component: () => import('../pages/files/add.vue')  
        }, 
        { 
          path: 'files/view/:id',
          component: () => import('../pages/files/view.vue') 
        }, 
        {
          path: 'profile',
          component: () => import('../pages/auth/profile.vue'),
        },
  
        {
          path: 'typography',
          component: () => import('../pages/others/typography.vue'),
        },
        {
          path: 'icons',
          component: () => import('../pages/others/icons.vue'),
        },
        {
          path: 'cards',
          component: () => import('../pages/others/cards.vue'),
        },
        {
          path: 'tables',
          component: () => import('../pages/others/tables.vue'),
        },
        {
          path: 'form-layouts',
          component: () => import('../pages/others/form-layouts.vue'),
        },
      ],
    },
    {
      path: '/',
      component: () => import('../layouts/blank.vue'),
      children: [
        {
          path: 'login',
          component: () => import('../pages/auth/login.vue'),
          meta: {
            requiresAuth: false
          }
        },
        {
          path: 'register',
          component: () => import('../pages/auth/register.vue'),
          meta: {
            requiresAuth: false
          }
        },
        {
          path: '/:pathMatch(.*)*',
          component: () => import('../pages/others/[...all].vue'),
        },
      ],
    },
  ],
})

router.beforeEach((to,from)=>{ 
  if(to.meta.requiresAuth==undefined && !localStorage.getItem('token')){
      return {path: 'login'}
  }
  if(to.meta.requiresAuth==false && localStorage.getItem('token')){
      return {path: '/'}
  }
});

export default router
