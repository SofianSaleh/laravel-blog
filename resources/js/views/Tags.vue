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
                                        @click="deleteTag(tag, i)"
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
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Editing.." : "Edit tag" }}</Button
                        >
                    </div>
                </Modal>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                tagName: ""
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            editData: {
                tagName: ""
            },
            tags: []
        };
    },
    methods: {
        async addTag() {
            if (this.data.tagName.trim() === "")
                return this.e("Tag name is Required");
            const res = await this.callApi("post", "/api/create_tag", {
                tagName: this.data.tagName
            });

            if (res.status === 201) {
                this.tags.unshift(res.data);
                this.s("Tag has Been Added");
                this.addModal = false;
                this.data.tagName = "";
            } else {
                if (res.status === 422) {
                    if (res.data.errors.tagName)
                        return this.i(res.data.errors.tagName[0]);
                } else {
                    this.swr();
                }
            }
        },
        async editTag() {
            if (this.editData.tagName.trim() === "")
                return this.e("Tag name is Required");
            const res = await this.callApi(
                "post",
                "/api/edit_tag",
                this.editData
            );

            if (res.status === 200) {
                let index = this.tags.findIndex(tag => tag.id === res.data.id);
                this.tags[index].tagName = res.data.tagName;
                this.s("Tag has Been Edited");
                this.editModal = false;
                this.editData = { tagName: "" };
            } else {
                if (res.status === 422) {
                    if (res.data.errors.tagName)
                        return this.i(res.data.errors.tagName[0]);
                } else {
                    this.swr();
                }
            }
        },
        showEditModal({ tagName, id }) {
            let obj = {
                id,
                tagName
            };
            this.editData = obj;
            this.editModal = true;
        }
    },
    async deleteTag(tag, i) {},
    async created() {
        const res = await this.callApi("get", "/api/get_all_tags");
        if (res.status === 200) {
            this.tags = res.data;
        } else {
            this.swr();
        }
    }
};
</script>
