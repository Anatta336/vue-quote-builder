import ProductIndex from './views/ProductIndex'
import ProductAdd from './views/ProductAdd'
import ProductEdit from './views/ProductEdit'
import QuoteIndex from './views/QuoteIndex'
import QuoteAdd from './views/QuoteAdd'
import QuoteEdit from './views/QuoteEdit'
import QuoteProducts from './views/QuoteProducts'

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
            path: '/quote/:id',
            name: 'quote.edit',
            component: QuoteEdit,
        },
        {
            // TODO: names don't quite match here - is it viewing or editing?
            path: '/quote/:id/products',
            name: 'quoteProducts.edit',
            component: QuoteProducts,
        }

    ],
};

export default routes;
