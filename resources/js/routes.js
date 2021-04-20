import ProductIndex from './views/ProductIndex'
import ProductAdd from './views/ProductAdd'
import ProductEdit from './views/ProductEdit'

const routes = {
    mode: 'history',
    routes: [
        {
            path: '/product',
            name: 'product.index',
            component: ProductIndex,
        },
        {
            path: '/product/add',
            name: 'product.add',
            component: ProductAdd,
        },
        {
            path: '/product/:id',
            name: 'product.edit',
            component: ProductEdit,
        },
    ],
};

export default routes;
