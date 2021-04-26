import Vue from 'vue'
import VueRouter from 'vue-router'
import Axios from 'axios';
import Routes from './routes';
import App from './views/App'

// make Axios available globally (would be nice to inject this dependency, somehow?)
window.axios = Axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// use VueRouter
Vue.use(VueRouter)

// create global filters
Vue.filter('penceAsPounds', function(value) {
    if (!value) {
        return '£0.00';
    }
    return '£' + (value / 100).toFixed(2);
})

const app = new Vue({
    el: '#app',
    components: { App },
    router: new VueRouter(Routes), // makes this.$router and this.$route available
});