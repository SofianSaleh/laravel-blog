<template>
    <div>
        <!-- Delete Category  -->

        <Modal :value="modalData.showDeleteModal" width="360">
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
                    @click="deleteCategory"
                    >Delete</Button
                >
            </div>
        </Modal>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            isDeleting: false
        };
    },
    methods: {
        async deleteCategory() {
            this.$store.commit("setDeleteModal");
            // this.isDeleting = true;
            // // "/api/tag/delete_Category"
            // const res = await this.callApi(
            //     "post",
            //     modalData.deleteURL,
            //     modalData.data
            // );

            // if (res.status === 200) {
            //     // ! convert to vuex
            //     this.categories.splice(this.deleteCategory.i, 1);
            //     this.s("Tag deleted Successfully");
            //     this.isDeleting = false;
            //     this.deleteModal = false;
            // } else {
            //     this.isDeleting = false;

            //     this.swr();
            // }
        }
    },
    computed: {
        ...mapGetters([
            {
                modalData: "getDeleteModalObj"
            }
        ])
    }
};
</script>
