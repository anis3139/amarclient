export default [
    {
        path: '/login',
        name: 'user.login',
        component: () => import('@/views/Login.vue'),
        meta: {
            guestUserOnly: true,
            layout: 'full',
        },
    },
    {
        path: '/register',
        name: 'user.register',
        component: () => import('@/views/Register.vue'),
        meta: {
            guestUserOnly: true,
            layout: 'full',
        },
    },
    {
        path: '/verify',
        name: 'user.email.verify',
        component: () => import('@/views/shop/verify.vue'),
        meta: {
            layout: 'full',
            guestUserOnly: true,
        },
    },
    {
        path: '/',
        name: 'user.homepage',
        component: () => import('@/views/Home.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Home',
        },
    },

    {
        path: '/client',
        name: 'shop.client',
        component: () => import('@/views/shop/client/Index.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Client',
            breadcrumb: [
                {
                    text: 'Client list',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/client/create',
        name: 'shop.client.create',
        component: () => import('@/views/shop/client/Create.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Create client',
            breadcrumb: [
                {
                    text: 'Client',
                },
                {
                    text: 'Create',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/client/edit/:id',
        name: 'shop.client.edit',
        component: () => import('@/views/shop/client/Edit.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Edit client',
            breadcrumb: [
                {
                    text: 'Client',
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },

    {
        path: '/payee',
        name: 'shop.payee',
        component: () => import('@/views/shop/payee/Index.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Payee',
            breadcrumb: [
                {
                    text: 'Payee list',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/payee/create',
        name: 'shop.payee.create',
        component: () => import('@/views/shop/payee/Create.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Create payee',
            breadcrumb: [
                {
                    text: 'Payee',
                },
                {
                    text: 'Create',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/payee/edit/:id',
        name: 'shop.payee.edit',
        component: () => import('@/views/shop/payee/Edit.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Edit payee',
            breadcrumb: [
                {
                    text: 'Payee',
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },

    {
        path: '/sale',
        name: 'shop.sale',
        component: () => import('@/views/shop/sale/Index.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Sales',
            breadcrumb: [
                {
                    text: 'Sales list',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/sale/create',
        name: 'shop.sale.create',
        component: () => import('@/views/shop/sale/Create.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Create sale',
            breadcrumb: [
                {
                    text: 'Sale',
                },
                {
                    text: 'Create',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/sale/edit/:id',
        name: 'shop.sale.edit',
        component: () => import('@/views/shop/sale/Edit.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Edit sale',
            breadcrumb: [
                {
                    text: 'Sale',
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/expense',
        name: 'shop.expense',
        component: () => import('@/views/shop/expense/Index.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Expenses',
            breadcrumb: [
                {
                    text: 'Expense list',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/expense/create',
        name: 'shop.expense.create',
        component: () => import('@/views/shop/expense/Create.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Create expense',
            breadcrumb: [
                {
                    text: 'expense',
                },
                {
                    text: 'Create',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/expense/edit/:id',
        name: 'shop.expense.edit',
        component: () => import('@/views/shop/expense/Edit.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Edit expense',
            breadcrumb: [
                {
                    text: 'expense',
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },

    {
        path: '/product',
        name: 'shop.product',
        component: () => import('@/views/shop/product/Index.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'product',
            breadcrumb: [
                {
                    text: 'product list',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/product/create',
        name: 'shop.product.create',
        component: () => import('@/views/shop/product/Create.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Create product',
            breadcrumb: [
                {
                    text: 'product',
                },
                {
                    text: 'Create',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/product/edit/:id',
        name: 'shop.product.edit',
        component: () => import('@/views/shop/product/Edit.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Edit product',
            breadcrumb: [
                {
                    text: 'product',
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/invoice/list',
        name: 'shop.invoice.list',
        component: () => import('@/views/shop/invoice/index.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'List invoice',
            breadcrumb: [
                {
                    text: 'invoice',
                },
                {
                    text: 'list',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/invoice/edit/:id',
        name: 'shop.invoice.edit',
        component: () => import('@/views/shop/invoice/edit.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Edit invoice',
            breadcrumb: [
                {
                    text: 'invoice',
                },
                {
                    text: 'edit',
                    active: true,
                },
            ],
        },
    },
  {
        path: '/invoice/preview/:id',
        name: 'shop.invoice.preview',
        component: () => import('@/views/shop/invoice/preview.vue'),
        meta: {
            authUserOnly: true,
            pageTitle: 'Preview invoice',
            breadcrumb: [
                {
                    text: 'invoice',
                },
                {
                    text: 'preview',
                    active: true,
                },
            ],
        },
    }
]
