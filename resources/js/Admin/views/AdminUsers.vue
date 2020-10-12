<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Users
                        <Button @click="addModal = true"
                            ><Icon type="md-add"></Icon> Add admin</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(user, i) in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td class="_table_name">
                                    {{ user.fullName }}
                                </td>
                                <td>
                                    {{ user.email }}
                                </td>
                                <td>
                                    {{ user.userType }}
                                </td>
                                <td>{{ user.created_at }}</td>

                                <td>
                                    <Button type="primary" size="small">
                                        View
                                    </Button>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(user)"
                                    >
                                        Edit
                                    </Button>
                                    <!-- deleteing here -->
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteModal(user, i)"
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
                    title="Add admin"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space" style="padding-bottom: 5px">
                        <Input
                            v-model="data.fullName"
                            type="text"
                            placeholder="Full name"
                        />
                    </div>
                    <div class="space" style="padding-bottom: 5px">
                        <Input
                            v-model="data.email"
                            type="email"
                            placeholder="Email"
                        />
                    </div>
                    <div class="space" style="padding-bottom: 5px">
                        <Input
                            v-model="data.password"
                            type="password"
                            placeholder="Password"
                        />
                    </div>
                    <div class="space" style="padding-bottom: 5px">
                        <Select
                            v-model="data.userType"
                            placeholder="Select User Type"
                        >
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
                        </Select>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addAdmin"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Adding.." : "Add Admin" }}</Button
                        >
                    </div>
                </Modal>
                <!-- Edit users -->
                <Modal
                    v-model="editModal"
                    title="Edit user"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space" style="padding-bottom: 5px">
                        <Input
                            v-model="editData.fullName"
                            type="text"
                            placeholder="Full name"
                        />
                    </div>
                    <div class="space" style="padding-bottom: 5px">
                        <Input
                            v-model="editData.email"
                            type="email"
                            placeholder="Email"
                        />
                    </div>
                    <div class="space" style="padding-bottom: 5px">
                        <Input
                            v-model="editData.password"
                            type="password"
                            placeholder="Password"
                        />
                    </div>
                    <div class="space" style="padding-bottom: 5px">
                        <Select
                            v-model="editData.userType"
                            placeholder="Select User Type"
                        >
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
                        </Select>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="editModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editUser"
                            :disabled="isEditing"
                            :loading="isEditing"
                            >Edit user</Button
                        >
                    </div>
                </Modal>

                <!-- Delete Tag -->

                <!-- <Modal v-model="deleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>
                            Are you sure you want to delete this tag?
                        </p>
                    </div>
                    <div slot="footer">
                        <Button
                            type="error"
                            size="large"
                            long
                            :loading="isDeleting"
                            :disabled="isDeleting"
                            @click="deleteTag"
                            >Delete</Button
                        >
                    </div>
                </Modal> -->
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
            // :loading="/**tag.isDeleting*/"
            data: {
                fullName: "",
                email: "",
                password: "",
                userType: ""
            },
            editData: {
                fullName: "",
                email: "",
                password: "",
                userType: ""
            },
            deleteData: {
                tagName: ""
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            isAdding: false,
            isDeleting: false,
            isEditing: false,
            users: []
        };
    },
    methods: {
        async addAdmin() {
            if (this.data.fullName.trim() === "")
                return this.e("Full name is Required");
            if (this.data.email.trim() === "")
                return this.e("Email is Required");
            if (this.data.password.trim() === "")
                return this.e("Password is Required");
            if (this.data.userType.trim() === "")
                return this.e("User Type is Required");

            this.isAdding = true;
            const res = await this.callApi(
                "post",
                "/api/user/create",
                this.data
            );

            if (res.status === 201) {
                this.users.unshift(res.data);
                this.s("User has Been Added");
                this.isAdding = false;
                this.addModal = false;
                this.data = {
                    fullName: "",
                    email: "",
                    password: "",
                    userType: ""
                };
            } else {
                if (res.status === 422) {
                    this.isAdding = false;
                    for (const i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.isAdding = false;
                    this.swr();
                }
            }
            this.isAdding = false;
        },
        async editUser() {
            if (this.editData.fullName.trim() === "")
                return this.e("Full name is Required");
            if (this.editData.email.trim() === "")
                return this.e("Email is Required");

            if (this.editData.userType.trim() === "")
                return this.e("User Type is Required");

            if (this.editData.password.trim() === "") {
                delete this.editData["password"];
            }

            this.isEditing = true;
            const res = await this.callApi(
                "post",
                "/api/user/edit",
                this.editData
            );
            if (res.status === 200) {
                let index = this.users.findIndex(
                    user => user.id === res.data.id
                );
                this.users[index] = res.data;
                this.s("User has Been Edited");
                this.isEditing = false;
                this.editModal = false;
                this.editData = {
                    fullName: "",
                    email: "",
                    password: "",
                    userType: ""
                };
            } else {
                if (res.status === 422) {
                    this.isEditing = false;
                    for (const i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.isEditing = false;
                    this.swr();
                }
            }
            this.isEditing = false;
        },
        showEditModal(user) {
            this.editData = {
                email: user.email,
                fullName: user.fullName,
                id: user.id,
                password: "",
                userType: user.userType
            };
            this.editModal = true;
        },
        async deleteTag() {
            // this.isDeleting = true;
            // const res = await this.callApi(
            //     "post",
            //     "/api/tag/delete_tag",
            //     this.deleteData
            // );
            // if (res.status === 200) {
            //     this.tags.splice(this.deleteTag.i, 1);
            //     this.s("Tag deleted Successfully");
            //     this.isDeleting = false;
            //     this.deleteModal = false;
            // } else {
            //     this.isDeleting = false;
            //     this.swr();
            // }
        },
        showDeleteModal(tag, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteURL: "/api/tag/delete_tag",
                deleteData: tag,
                isDeleted: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
        }
    },
    async created() {
        const res = await this.callApi("get", "/api/user/get_all");
        if (res.status === 200) {
            this.users = res.data;
        } else {
            this.swr();
        }
    },
    computed: {
        // ...mapGetters(["getDeleteModalObj"])
    },
    watch: {
        // getDeleteModalObj(obj) {
        //     if (obj.isDeleted) {
        //         let index = this.tags.findIndex(
        //             tag => tag.id === obj.deleteData.id
        //         );
        //         this.tags.splice(index, 1);
        //         this.$store.commit("setDeleteModal", false);
        //     }
        // }
    }
};
</script>
