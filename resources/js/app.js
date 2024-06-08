import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import {createBootstrap} from 'bootstrap-vue-next';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
import VueSidebarMenu from 'vue-sidebar-menu';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css';
import 'admin-lte/dist/css/adminlte.css';
import 'admin-lte/dist/js/adminlte';
import './fontawesome'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

createApp(App)
    .use(router)
    .use(createBootstrap({components: true, directives: true}))
    .use(VueSidebarMenu)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount('#app');