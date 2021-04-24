import Vue from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router";

//Bootstrap
import { BootstrapVue } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)

//FontAwesome
import { library } from '@fortawesome/fontawesome-svg-core'
import { faThumbsUp, faThumbsDown, faExclamation, faEye, faEyeSlash, faTrashAlt, faBars, faCheckCircle, faDolly, faLink } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faThumbsUp, faThumbsDown, faExclamation, faEye, faEyeSlash, faTrashAlt, faBars, faCheckCircle, faDolly, faLink)
Vue.component('font-awesome-icon', FontAwesomeIcon)

//Vue Masonry Layout
import VueMasonry from 'vue-masonry-css'
Vue.use(VueMasonry)

//Vue FAB
import fab from 'vue-fab'
Vue.component('vue-fab', fab)

Vue.config.productionTip = false;

new Vue({
    router,
    render: (h) => h(App),
}).$mount("#app");
