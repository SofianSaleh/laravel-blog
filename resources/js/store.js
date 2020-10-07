import Vue from "vue";
import Vuex from "vuex";

Vue.use(vVuex);

export default new Vuex.Store({
    state: {
        deleteModalObj: {
            showModal: false,
            deleteURL: "",
            data: {}
        }
    },
    getters: {
        getDeleteModalObj(state) {
            return state.deleteModalObj;
        }
    },
    mutations: {},
    actions: {}
});
