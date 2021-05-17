export default [
  {
    title: 'Home',
    route: 'user.homepage',
    icon: 'HomeIcon',
  },
  {
    title: 'Clients',
    route: 'shop.client',
    icon: 'FileIcon',
  },
  {
    title: 'Payee',
    route: 'shop.payee',
    icon: 'FileIcon',
  },
  {
    title: 'Sale',
    route: 'shop.sale',
    icon: 'FileIcon',
  },
  {
    title: 'Expenses',
    route: 'shop.expense',
    icon: 'FileIcon',
  },
  {
    title: 'Product/Project',
    route: 'shop.product',
    icon: 'FileIcon',
  },
  {
    title: 'SMS',
    route: '',
    icon: 'MailIcon',
  },
  {
    title: 'Employee',
    icon: 'UserIcon',
    children: [
      {
        title: 'Attendance',
        route: '',
      },
      {
        title: 'Leave',
        route: '',
      },
      {
        title: 'Salary',
        route: '',
      },
    ],
  },
  {
    title: 'Office',
    icon: 'FileIcon',
    children: [
      {
        title: 'TODO',
        route: '',
      },
      {
        title: 'Calender',
        route: '',
      },
      {
        title: 'Meeting',
        route: '',
      },
      {
        title: 'Notice Board',
        route: '',
      },
    ],
  },
  {
    title: 'User',
    route: '',
    icon: 'UserIcon',
  },
  {
    title: 'Settings',
    route: '',
    icon: 'FileIcon',
  },{
    title: 'Invoice',
    icon: 'FileTextIcon',
    route: 'shop.invoice.list',
   
  },
]
