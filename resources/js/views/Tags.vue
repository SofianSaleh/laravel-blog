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
                        <Button @click='addModal=true'><Icon type="md-add"></Icon> Add Tag</Button>
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
                            <tr>
                                <td>1</td>
                                <td class="_table_name">
                                    Manhattan's art center "Shed" opening
                                    ceremony
                                </td>
                                <td>Economy</td>
                                <td>
                                    <Button type="primary" size="small">
                                        View
                                    </Button>
                                    <Button type="info" size="small">
                                        Edit
                                    </Button>
                                    <Button type="error" size="small">
                                        Delete
                                    </Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <Modal
                    v-model="addModal"
                    title="Add New Tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div slot='footer'>
                        <Button type='primary'>Add</Button>
                        <Button type='default' @click='addModal=false'>Cancel</Button>
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
          data:{
              tagName: ""
          } ,
          addModal: false,
          isAdding: false
        };
    },
    methods:{
        addTag() {
            if(this.data.tagName.trim() === '') return this.e('Tag name is Required')
        }
    }
};
</script>

// export default {
//     data() {
//         return {
//             modal1: false
//         };
//     },
//     methods: {
//         ok() {
//             this.$Message.info("Clicked ok");
//         },
//         cancel() {
//             this.$Message.info("Clicked cancel");
//         }
//     }
// };
// </script>
