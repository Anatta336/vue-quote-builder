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
        {
            path: '/quote',
            name: 'quote.index',
            component: QuoteIndex,
        },
        {
            path: '/quote/add',
            name: 'quote.add',
            component: QuoteAdd,
        },
        {
            path: '/quote',
            name: 'quote.edit',
            component: QuoteEdit,
        },

    ],
};

export default routes;
