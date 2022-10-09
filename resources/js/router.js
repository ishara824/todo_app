import { createWebHistory, createRouter } from 'vue-router';
import dashboard from './pages/dashboard.vue';
import login from './pages/login.vue';
import register from './pages/register.vue';
import todo_dashboard from './pages/todo_dashboard.vue';
import add_new_list from './pages/add_new_list.vue';
import add_new_item from './pages/add_new_item.vue';
import update_task from './pages/update_task.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: dashboard
    },
    {
        path: '/login',
        name: 'Login',
        component: login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: register,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: todo_dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/new/list',
        name: 'List',
        component: add_new_list,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/new/item/:id',
        name: 'Item',
        component: add_new_item,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/update/task/:id',
        name: 'UpdateTask',
        component: update_task,
        meta: {
            requiresAuth: true
        }
    }
];

const router = createRouter({
   history: createWebHistory(),
    routes
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')) {
        return { name: 'Login' }
    }
    if (to.meta.requiresAuth == false && localStorage.getItem('token')) {
        return { name: 'Dashboard' }
    }
});

export default router;
