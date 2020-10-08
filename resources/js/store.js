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
        }
    },
    mutations: {
        setDeleteModal(state, payload) {
            const deleteModalObj = {
                showDeleteModal: false,
                deleteURL: "",
                deleteData: payload.deleteData,
                isDeleted: payload.success
            };
            state.deleteModalObj = deleteModalObj;
        },
        setDeletingModalObj(state, data) {
            state.deleteModalObj = data;
        }
    },
    actions: {}
});
