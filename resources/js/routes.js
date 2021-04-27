import ProductList from './views/ProductList.vue';
import QuoteIndex from './views/QuoteIndex.vue';
import QuoteView from './views/QuoteView.vue';
import QuoteEdit from './views/QuoteEdit.vue';

const routes = {
    mode: 'history',
    routes: [
        {
            path: '/products',
            name: 'products.index',
            component: ProductList,
        },
        {
            path: '/quotes',
            name: 'quotes.index',
            component: QuoteIndex,
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
