import ProductIndex from './views/ProductIndex'
import ProductAdd from './views/ProductAdd'

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
    ],
};

export default routes;
