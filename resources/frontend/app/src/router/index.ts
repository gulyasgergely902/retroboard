import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Index from "../views/Index.vue";
import Board from "../views/Board.vue";

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
    {
        path: "/",
        name: "Index",
        component: Index,
    },
    {
        path: "/board/:id",
        name: "Board",
        component: Board,
    },
];

const router = new VueRouter({
    routes,
});

export default router;
