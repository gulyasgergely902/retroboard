require('./bootstrap');

window.Vue = require('vue');

Vue.component('front-page', require('./components/Front.vue').default);
Vue.component('display-page', require('./components/StickyDisplay.vue'));

const app = new Vue({
    el: '#app',
});
