import Vue from "vue";
import VueRouter from "vue-router";

import UserLoggedView from "./components/UserLoggedView";
import ListaOfertas from "./components/ListaOfertas";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/UserLoggedView",
            name: "UserLoggedView",
            component: UserLoggedView,
        },
        {
            path: "/",
            name: "ListaOfertas",
            component: ListaOfertas,
        },
    ],
});

export default router;
