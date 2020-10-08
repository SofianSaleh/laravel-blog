import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        deleteModalObj: {
            showDeleteModal: false,
            deleteURL: "",
            data: {},
            isDeleted: false
        }
    },
    getters: {
        getDeleteModalObj(state) {
            return state.deleteModalObj;
        }
    },
    mutations: {
        setDeleteModal(state) {
            state.deleteModalObj.isDeleted = true;
        },
        setDeletingModalObj(state, data) {
            state.deleteModalObj = data;
        }
    },
    actions: {}
});
