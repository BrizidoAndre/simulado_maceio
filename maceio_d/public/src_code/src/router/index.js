import {createRouter, createWebHistory} from 'vue-router'
import LoginView from "@/views/LoginView.vue";
import {token} from "@/helpers/global.js";
import CustomersView from "@/views/CustomersView.vue";
import PlansView from "@/views/PlansView.vue";
import SubscriptionsView from "@/views/SubscriptionsView.vue";
import TransactionsView from "@/views/TransactionsView.vue";
import WorkersView from "@/views/WorkersView.vue";

/*
            this meta auth is being responsible to check if page needs authentication
             */
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: LoginView,

            meta: {
                auth: false,
            }
        },
        {
            path: '/',
            name: 'customers',
            component: CustomersView,
            meta: {
                auth: true,
            }
        },
        {
            path: '/plans',
            name: 'plans',
            component: PlansView,
            meta: {
                auth: true,
            }
        },
        {
            path: '/subscriptions',
            name: 'subscriptions',
            component: SubscriptionsView,
            meta: {
                auth: true,
            }
        },
        {
            path: '/transactions',
            name: 'transactions',
            component: TransactionsView,
            meta: {
                auth: true,
            }
        },
        {
            path: '/workers',
            name: 'workers',
            component: WorkersView,
            meta: {
                auth: true,
            }
        },
    ],
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
})

router.beforeEach((to, from) => {
    if (to?.meta?.auth && !token.value) {
        return {
            name: 'login',
        }
    }
    return true;
})

export default router
