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
    computed: {
        ...mapGetters([
            {
                modalData: "getDeleteModalObj"
            }
        ])
    }
};
</script>
