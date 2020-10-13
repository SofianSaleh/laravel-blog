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
        },
        user: {}
    },
    getters: {
        getDeleteModalObj(state) {
            return state.deleteModalObj;
        },
        getLoggedInUser(state) {
            return state.user;
        }
    },
    mutations: {
        setDeleteModal(state, payload) {
            let index = state.deleteModalObj.deleteData.id || -1;
            const deleteModalObj = {
                showDeleteModal: false,
                deleteURL: "",
                deleteData: { id: index },
                isDeleted: payload
            };
            state.deleteModalObj = deleteModalObj;
        },
        setDeletingModalObj(state, data) {
            state.deleteModalObj = data;
        },
        updateUser(state, data) {
            console.log(state, data, "Store");
            state.user = data;
        }
    },
    actions: {}
});
