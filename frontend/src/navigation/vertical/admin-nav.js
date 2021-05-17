export default [
  {
    title: 'Home',
    route: 'admin.homepage',
    icon: 'HomeIcon',
  },
  {
    title: 'Shop',
    route: 'admin.shop',
    icon: 'FileIcon',
  },
  {
    title: 'Expense Category',
    icon: 'FileIcon',
    children: [
      {
        title: 'Category',
        route: 'admin.category',
      },
      {
        title: 'Sub Category',
        route: 'admin.sub-category',
      },
    ],
  },
]
