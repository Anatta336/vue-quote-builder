import ProductIndex from './views/ProductIndex'
import ProductAdd from './views/ProductAdd'
import ProductEdit from './views/ProductEdit'
import QuoteIndex from './views/QuoteIndex'
import QuoteAdd from './views/QuoteAdd'
import QuoteView from './views/QuoteView'
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
            path: '/products/:id/edit',
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
            name: 'quotes.view',
            component: QuoteView,
        },
        {
            path: '/quotes/:id/edit',
            name: 'quotes.edit',
            component: QuoteEdit,
        },
    ],
};

export default routes;
