import Vue from "vue";
import VueRouter from "vue-router";

import Home from "./views/Home.vue";
import Tags from "./views/Tags.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: Home
        },
        {
            path: "/tags",
            component: Tags
        }
    ]
});

export default router;
