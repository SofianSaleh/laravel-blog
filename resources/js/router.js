import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VuewRouter({
    mode: "history",
    routes: [{ path: "/", component: Home }],
});

export default router;
