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
import { IconDefinition, library } from '@fortawesome/fontawesome-svg-core'
import { faThumbsUp, faThumbsDown, faExclamation, faEye, faEyeSlash, faTrashAlt, faBars, faCheckCircle, faDolly, faLink, faLayerGroup, faPlus } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faThumbsUp as IconDefinition)
library.add(faThumbsDown as IconDefinition)
library.add(faExclamation as IconDefinition)
library.add(faEye as IconDefinition)
library.add(faEyeSlash as IconDefinition)
library.add(faTrashAlt as IconDefinition)
library.add(faBars as IconDefinition)
library.add(faCheckCircle as IconDefinition)
library.add(faDolly as IconDefinition)
library.add(faLink as IconDefinition)
library.add(faLayerGroup as IconDefinition)
library.add(faPlus as IconDefinition)
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
