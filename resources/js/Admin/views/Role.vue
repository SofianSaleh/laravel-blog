<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Role Management
                        <Button @click="addModal = true"
                            ><Icon type="md-add"></Icon> Add New Role</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Role Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(role, i) in roles" :key="role.id">
                                <td>{{ role.id }}</td>
                                <td class="_table_name">
                                    {{ role.roleName }}
                                </td>
                                <td>{{ role.created_at }}</td>
                                <td>
                                    <Button type="primary" size="small">
                                        View
                                    </Button>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(role)"
                                    >
                                        Edit
                                    </Button>
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteModal(role, i)"
                                        :loading="role.isDeleting"
                                    >
                                        Delete
                                    </Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Create tag -->
                <Modal
                    v-model="addModal"
                    title="Add Role"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="data.roleName"
                        placeholder="Add role name"
                    />
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="add"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Adding.." : "Add role" }}</Button
                        >
                    </div>
                </Modal>
                <!-- Edit tags -->
                <Modal
                    v-model="editModal"
                    title="Edit role"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="editData.roleName"
                        placeholder="Edit role name"
                    />
                    <div slot="footer">
                        <Button type="default" @click="editModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="edit"
                            :disabled="isEditing"
                            :loading="isEditing"
                            >Edit role</Button
                        >
                    </div>
                </Modal>

                <deleteModal></deleteModal>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import deleteModal from "../components/DeleteModal";
export default {
    components: {
        deleteModal
    },
    data() {
        return {
            data: {
                roleName: ""
            },
            editData: {
                roleName: ""
            },
            deleteData: {
                roleName: ""
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            isAdding: false,
            isDeleting: false,
            isEditing: false,
            roles: []
        };
    },
    methods: {
        async add() {
            if (this.data.roleName.trim() === "")
                return this.e("Role name is Required");

            this.isAdding = true;
            const res = await this.callApi(
                "post",
                "/api/role/create_role",
                this.data
            );

            if (res.status === 201) {
                this.roles.unshift(res.data);
                this.s("Role has Been Added");
                this.isAdding = false;
                this.addModal = false;
                this.data.rolename = "";
            } else {
                if (res.status === 422) {
                    this.isAdding = false;
                    if (res.data.errors.roleName)
                        return this.i(res.data.errors.roleName[0]);
                } else {
                    this.isAdding = false;
                    this.swr();
                }
            }
            this.isAdding = false;
        },
        async edit() {
            if (this.editData.roleName.trim() === "")
                return this.e("Role name is Required");
            this.isEditing = true;
            const res = await this.callApi(
                "post",
                "/api/role/edit_role",
                this.editData
            );

            if (res.status === 200) {
                let index = this.roles.findIndex(
                    role => role.id === res.data.id
                );
                this.roles[index].roleName = res.data.roleName;
                this.s("Role has Been Edited");
                this.isEditing = false;
                this.editModal = false;
                this.editData = { roleName: "" };
            } else {
                if (res.status === 422) {
                    this.isEditing = false;
                    if (res.data.errors.roleName)
                        return this.i(res.data.errors.roleName[0]);
                } else {
                    this.isEditing = false;
                    this.swr();
                }
            }
            this.isEditing = false;
        },
        showEditModal({ roleName, id }) {
            let obj = {
                id,
                roleName
            };
            this.editData = obj;
            this.editModal = true;
        },
        showDeleteModal(role, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteURL: "/api/role/delete_role",
                deleteData: role,
                isDeleted: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
        }
    },
    async created() {
        const res = await this.callApi("get", "/api/role/get_roles");
        if (res.status === 200) {
            this.roles = res.data;
        } else {
            this.swr();
        }
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"])
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleted) {
                let index = this.roles.findIndex(
                    role => role.id === obj.deleteData.id
                );
                this.roles.splice(index, 1);
                this.$store.commit("setDeleteModal", false);
            }
        }
    }
};
</script>
