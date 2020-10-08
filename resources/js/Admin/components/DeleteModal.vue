<template>
    <div>
        <!-- Delete Category  -->

        <Modal
            :value="modalData.showDeleteModal"
            width="360"
            :mask-closable="false"
            :closable="false"
        >
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
                <Button type="default" size="large" @click="closeModal"
                    >close</Button
                >
                <Button
                    type="error"
                    size="large"
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
            this.isDeleting = true;
            // "/api/tag/delete_Category"
            const res = await this.callApi(
                "post",
                this.modalData.deleteURL,
                this.modalData.deleteData
            );

            if (res.status === 200) {
                // ! convert to vuex
                // this.categories.splice(this.deleteCategory.i, 1);
                this.s("Tag deleted Successfully");
                this.$store.commit("setDeleteModal", true);
                this.isDeleting = false;
            } else {
                this.$store.commit("setDeleteModal", false);
                this.isDeleting = false;
                this.swr();
            }
        },
        closeModal() {
            this.$store.commit("setDeleteModal", false);
        }
    },
    computed: {
        ...mapGetters({
            modalData: "getDeleteModalObj"
        })
    }
};
</script>
