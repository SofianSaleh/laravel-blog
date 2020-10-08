<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Categories
                        <Button @click="addCategoryModal = true"
                            ><Icon type="md-add"></Icon> Add Category</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Icon Image</th>
                                <th>Category name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr
                                v-for="(category, i) in categories"
                                :key="category.id"
                            >
                                <td>{{ category.id }}</td>
                                <td class="table_image">
                                    <img
                                        :src="`/uploads/${category.iconImage}`"
                                        :alt="category.name"
                                    />
                                </td>
                                <td class="_table_name">
                                    {{ category.name }}
                                </td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button type="primary" size="small">
                                        View
                                    </Button>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(category)"
                                    >
                                        Edit
                                    </Button>
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteModal(category, i)"
                                        :loading="category.isDeleting"
                                    >
                                        Delete
                                    </Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Create Category -->
                <Modal
                    v-model="addCategoryModal"
                    title="Add Category"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="data.name"
                        placeholder="Add Category name"
                    />
                    <div class="space"></div>
                    <Upload
                        ref="uploads"
                        type="drag"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-with': 'XMLHttpRequest'
                        }"
                        :format="['jpg', 'jpeg', 'png']"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        action="/api/upload"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="this.data.iconImage">
                        {{ console.log(this.data.iconImage) }}
                        <img :src="`/uploads/${this.data.iconImage}`" />
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline" @click="removeImg" />
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addCategoryModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addCategory"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Adding.." : "Add Category"
                            }}</Button
                        >
                    </div>
                </Modal>
                <!-- Edit Category -->
                <Modal
                    v-model="editModal"
                    title="Edit Category"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="editData.name"
                        placeholder="Edit Category name"
                    />
                    <div class="space"></div>
                    <Upload
                        v-show="this.showUpload"
                        ref="editData"
                        type="drag"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-with': 'XMLHttpRequest'
                        }"
                        :format="['jpg', 'jpeg', 'png']"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        action="/api/upload"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div
                        class="demo-upload-list"
                        v-if="this.editData.iconImage"
                    >
                        <img :src="`/uploads/${this.editData.iconImage}`" />
                        <div class="demo-upload-list-cover">
                            <Icon
                                type="ios-trash-outline"
                                @click="removeImg(false)"
                            />
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="colseEditModal"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editCategory"
                            :disabled="isEditing"
                            :loading="isEditing"
                            >Edit Category</Button
                        >
                    </div>
                </Modal>
                <deleteModal></deleteModal>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from "../components/DeleteModal";
import { mapGetters } from "vuex";
export default {
    components: {
        deleteModal
    },
    data() {
        return {
            data: {
                iconImage: "",
                name: ""
            },
            editData: {
                name: "",
                iconImage: ""
            },
            deleteData: {
                name: "",
                iconImage: ""
            },
            addCategoryModal: false,
            editModal: false,
            // deleteModal: false,
            isAdding: false,
            isEditing: false,
            categories: [],
            token: "",

            showUpload: false,
            isEditingItem: false
        };
    },
    methods: {
        async addCategory() {
            if (this.data.name.trim() === "")
                return this.e("Category name is Required");
            if (this.data.iconImage.trim() === "")
                return this.e("Category image is Required");
            console.log(this.data.name);
            this.isAdding = true;
            this.data.iconName = `/uploads/${this.data.iconImage}`;
            const res = await this.callApi(
                "post",
                "/api/category/add",
                this.data
            );

            if (res.status === 201) {
                this.categories.unshift(res.data);
                this.s("Category has Been Added");
                this.isAdding = false;
                this.addCategoryModal = false;
                this.data = {
                    iconImage: "",
                    name: ""
                };
                console.log(this.data);
            } else {
                if (res.status === 422) {
                    this.isAdding = false;
                    if (res.data.errors.name)
                        return this.i(res.data.errors.name[0]);
                    if (res.data.errors.iconImage)
                        return this.i(res.data.errors.iconImage[0]);
                } else {
                    this.isAdding = false;
                    this.swr();
                }
            }
            this.isAdding = false;
        },
        async editCategory() {
            if (this.editData.name.trim() === "")
                return this.e("Category name is Required");
            if (this.editData.iconImage.trim() === "")
                return this.e("category image is Required");

            this.isEditing = true;
            const res = await this.callApi(
                "post",
                "/api/category/edit",
                this.editData
            );

            if (res.status === 200) {
                let index = this.categories.findIndex(
                    category => category.id === res.data.id
                );
                console.log(this.categories[index], this.categories);
                this.categories[index].name = res.data.name;
                this.categories[index].iconImage = res.data.iconImage;
                this.s("Tag has Been Edited");
                this.isEditing = false;

                this.editModal = false;
                this.isEditingItem = false;
                this.editData = { name: "", iconImage: "" };
            } else {
                if (res.status === 422) {
                    this.isEditing = false;

                    if (res.data.errors.name)
                        return this.i(res.data.errors.name[0]);
                    if (res.data.errors.iconImage)
                        return this.i(res.data.errors.iconImage[0]);
                } else {
                    this.isEditing = false;

                    this.swr();
                }
            }
            this.isEditing = false;
        },
        showEditModal({ id, name, iconImage }) {
            let obj = {
                id,
                name,
                iconImage
            };
            this.editData = obj;

            this.editModal = true;
            this.isEditingItem = true;
        },

        showDeleteModal(category, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteURL: "/api/category/delete",
                deleteData: category,
                isDeleted: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
        },
        handleSuccess(res, file) {
            if (this.isEditingItem) {
                return (this.editData.iconImage = res);
            }
            this.data.iconImage = res;
        },
        handleError(res, file) {
            this.$Notice.warning({
                title: "The file format is wrong",
                desc: `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "Something went wrong"
                }`
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select jpg or png."
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M."
            });
        },
        async removeImg(type = true) {
            let imageName;
            if (!type) {
                // for editing
                this.showUpload = true;

                imageName = this.editData.iconImage;
                this.editData.iconImage = "";
                this.$refs.editData.clearFiles();
            } else {
                imageName = this.data.iconImage;
                this.data.iconImage = "";
                this.$refs.uploads.clearFiles();
            }
            const res = await this.callApi("post", "/api/remove_img", {
                name: imageName
            });

            if (res.status !== 200) {
                this.data.iconImage = imageName;
                this.swr();
            }
        },
        colseEditModal() {
            this.isEditingItem = false;
            this.editModal = false;
        }
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi(
            "get",
            "/api/category/get_all_categories"
        );
        if (res.status === 200) {
            this.categories = res.data;
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
                let index = this.categories.findIndex(
                    category => category.id === obj.deleteData.id
                );
                this.categories.splice(index, 1);
                this.$store.commit("setDeleteModal", false);
            }
        }
    }
};
</script>
<style>
.demo-upload-list {
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    margin-right: 4px;
}
.demo-upload-list img {
    width: 100%;
    height: 100%;
}
.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
}
.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}
.demo-upload-list-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
