import { createRouter, createWebHistory } from "vue-router";
import invoiceIndex from "../components/invoice/index.vue";
import invoiceCreate from "../components/invoice/create.vue";

import NotFound from "../components/NotFound.vue";

const routes = [
    {
        path: '/',
        component: invoiceIndex,
    },

    {
        path: '/invoice/create',
        component: invoiceCreate,
    },

    {
        path: '/:pathMatch(.*)*',
        component: NotFound,

    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;