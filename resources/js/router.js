import Vue from "vue";
import VueRouter from "vue-router";

import Home from "./admin/views/Home.vue";
import Tags from "./admin/views/Tags.vue";
import Category from "./admin/views/Category.vue";

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
        },
        {
            path: "/category",
            component: Category
        }
    ]
});

export default router;
