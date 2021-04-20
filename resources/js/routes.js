import Hello from './views/Hello'
import Home from './views/Home'
import Products from './views/Products'

const routes = {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
        },
        {
            path: '/product',
            name: 'products',
            component: Products,
        },
    ],
};

export default routes;
