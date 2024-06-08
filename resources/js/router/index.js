import { createRouter, createWebHistory } from "vue-router";
import Home from '../components/HomePage.vue';
import NetworkVisualization from '../components/NetworkVisualization.vue';
import NotFound from '../components/NotFoundPage.vue';
import NodeList from '../components/NodeList.vue';
import ConnectionList from '../components/ConnectionList.vue';
import Dashboard from '../components/Dashboard.vue';
import Login from '../components/LoginForm.vue';

const routes = [
    {
        path: '/',
        component: Login,
        name: 'index',
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: { requiresAuth: true }
    },
    {
        path: '/diagram',
        component: NetworkVisualization,
        name: 'diagram',
        meta: { requiresAuth: true }
    },
    {
        path: '/node-list',
        component: NodeList,
        name: 'node-list',
        meta: { requiresAuth: true }
    },
    {
        path: '/connections-list',
        component: ConnectionList,
        name: 'connections-list',
        meta: { requiresAuth: true }
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound,
        name: 'not-found'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const isAuthenticated = !!localStorage.getItem('token');

    if (requiresAuth && !isAuthenticated) {
        next({ name: 'login' });
    } else if (to.name === 'login' && isAuthenticated) {
        next({ name: 'dashboard' });
    } else {
        next();
    }
  });

export default router;