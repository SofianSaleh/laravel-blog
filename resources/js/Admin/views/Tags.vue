<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Tags
                        <Button @click="addModal = true"
                            ><Icon type="md-add"></Icon> Add Tag</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Tag Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(tag, i) in tags" :key="tag.id">
                                <td>{{ tag.id }}</td>
                                <td class="_table_name">
                                    {{ tag.tagName }}
                                </td>
                                <td>{{ tag.created_at }}</td>
                                <td>
                                    <Button type="primary" size="small">
                                        View
                                    </Button>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(tag)"
                                    >
                                        Edit
                                    </Button>
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteModal(tag, i)"
                                        :loading="tag.isDeleting"
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
                    title="Add tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input v-model="data.tagName" placeholder="Add tag name" />
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addTag"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Adding.." : "Add tag" }}</Button
                        >
                    </div>
                </Modal>
                <!-- Edit tags -->
                <Modal
                    v-model="editModal"
                    title="Edit tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="editData.tagName"
                        placeholder="Edit tag name"
                    />
                    <div slot="footer">
                        <Button type="default" @click="editModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editTag"
                            :disabled="isEditing"
                            :loading="isEditing"
                            >Edit tag</Button
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
            data: {
                tagName: ""
            },
            editData: {
                tagName: ""
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
            tags: []
        };
    },
    methods: {
        async addTag() {
            if (this.data.tagName.trim() === "")
                return this.e("Tag name is Required");

            this.isAdding = true;
            const res = await this.callApi("post", "/api/tag/create_tag", {
                tagName: this.data.tagName
            });

            if (res.status === 201) {
                this.tags.unshift(res.data);
                this.s("Tag has Been Added");
                this.isAdding = false;
                this.addModal = false;
                this.data.tagName = "";
            } else {
                if (res.status === 422) {
                    this.isAdding = false;
                    if (res.data.errors.tagName)
                        return this.i(res.data.errors.tagName[0]);
                } else {
                    this.isAdding = false;
                    this.swr();
                }
            }
            this.isAdding = false;
        },
        async editTag() {
            if (this.editData.tagName.trim() === "")
                return this.e("Tag name is Required");

            this.isEditing = true;
            const res = await this.callApi(
                "post",
                "/api/tag/edit_tag",
                this.editData
            );

            if (res.status === 200) {
                let index = this.tags.findIndex(tag => tag.id === res.data.id);
                this.tags[index].tagName = res.data.tagName;
                this.s("Tag has Been Edited");
                this.isEditing = false;

                this.editModal = false;
                this.editData = { tagName: "" };
            } else {
                if (res.status === 422) {
                    this.isEditing = false;

                    if (res.data.errors.tagName)
                        return this.i(res.data.errors.tagName[0]);
                } else {
                    this.isEditing = false;

                    this.swr();
                }
            }
            this.isEditing = false;
        },
        showEditModal({ tagName, id }) {
            let obj = {
                id,
                tagName
            };
            this.editData = obj;
            this.editModal = true;
        },
        async deleteTag() {
            this.isDeleting = true;

            const res = await this.callApi(
                "post",
                "/api/tag/delete_tag",
                this.deleteData
            );

            if (res.status === 200) {
                this.tags.splice(this.deleteTag.i, 1);
                this.s("Tag deleted Successfully");
                this.isDeleting = false;
                this.deleteModal = false;
            } else {
                this.isDeleting = false;

                this.swr();
            }
        },
        showDeleteModal(tag, i) {
            console.log("hi");
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
        const res = await this.callApi("get", "/api/tag/get_all_tags");
        if (res.status === 200) {
            this.tags = res.data;
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
                let index = this.tags.findIndex(
                    tag => tag.id === obj.deleteData.id
                );
                this.tags.splice(index, 1);
                this.$store.commit("setDeleteModal", false);
            }
        }
    }
};
</script>
