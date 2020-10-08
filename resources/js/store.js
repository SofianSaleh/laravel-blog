import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        deleteModalObj: {
            showDeleteModal: false,
            deleteURL: "",
            deleteData: {},
            isDeleted: false
        }
    },
    getters: {
        getDeleteModalObj(state) {
            return state.deleteModalObj;
        },
        getDeleteStatus(state) {
            return state.deleteModalObj.isDeleted;
        }
    },
    mutations: {
        setDeleteModal(state, payload) {
            state.deleteModalObj.showDeleteModal = false;
            state.deleteModalObj.isDeleted = payload;
        },
        setDeletingModalObj(state, data) {
            state.deleteModalObj = data;
        }
    },
    actions: {}
});
