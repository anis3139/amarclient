export default [
  {
    path: '/admin/login',
    name: 'admin.login',
    component: () => import('@/views/admin/Login.vue'),
    meta: {
      guestAdminOnly: true,
      layout: 'full',
    },
  },
  {
    path: '/admin/home',
    name: 'admin.homepage',
    component: () => import('@/views/admin/Home.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Home',
    },
  },
  {
    path: '/admin/shop',
    name: 'admin.shop',
    component: () => import('@/views/admin/shop/Index.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Shops',
      breadcrumb: [
        {
          text: 'Shop list',
          active: true,
        },
      ],
    },
  },
  {
    path: '/admin/category',
    name: 'admin.category',
    component: () => import('@/views/admin/category/Index.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Category',
      breadcrumb: [
        {
          text: 'Category list',
          active: true,
        },
      ],
    },
  },
  {
    path: '/admin/category/create',
    name: 'admin.category.create',
    component: () => import('@/views/admin/category/Create.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Category',
      breadcrumb: [
        {
          text: 'Create',
          active: true,
        },
      ],
    },
  },
  {
    path: '/category/edit/:id',
    name: 'admin.category.edit',
    component: () => import('@/views/admin/category/Edit.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Edit category',
      breadcrumb: [
        {
          text: 'category',
        },
        {
          text: 'Edit',
          active: true,
        },
      ],
    },
  },
  {
    path: '/admin/sub-category',
    name: 'admin.sub-category',
    component: () => import('@/views/admin/sub-category/Index.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Sub Category',
      breadcrumb: [
        {
          text: 'Category list',
          active: true,
        },
      ],
    },
  },
  {
    path: '/admin/sub-category/create',
    name: 'admin.sub-category.create',
    component: () => import('@/views/admin/sub-category/Create.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Category',
      breadcrumb: [
        {
          text: 'Create',
          active: true,
        },
      ],
    },
  },
  {
    path: '/sub-category/edit/:id',
    name: 'admin.sub-category.edit',
    component: () => import('@/views/admin/sub-category/Edit.vue'),
    meta: {
      authAdminOnly: true,
      pageTitle: 'Edit category',
      breadcrumb: [
        {
          text: 'category',
        },
        {
          text: 'Edit',
          active: true,
        },
      ],
    },
  },
]
