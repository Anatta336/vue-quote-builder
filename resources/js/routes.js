import ProductIndex from './views/ProductIndex'
import ProductAdd from './views/ProductAdd'
import ProductEdit from './views/ProductEdit'
import QuoteIndex from './views/QuoteIndex'
import QuoteAdd from './views/QuoteAdd'
import QuoteEdit from './views/QuoteEdit'

const routes = {
    mode: 'history',
    routes: [
        {
            path: '/products',
            name: 'products.index',
            component: ProductIndex,
        },
        {
            path: '/products/add',
            name: 'products.add',
            component: ProductAdd,
        },
        {
            path: '/products/:id',
            name: 'products.edit',
            component: ProductEdit,
        },
        {
            path: '/quotes',
            name: 'quotes.index',
            component: QuoteIndex,
        },
        {
            path: '/quotes/add',
            name: 'quotes.add',
            component: QuoteAdd,
        },
        {
            path: '/quotes/:id',
            name: 'quotes.edit',
            component: QuoteEdit,
        },
    ],
};

export default routes;
