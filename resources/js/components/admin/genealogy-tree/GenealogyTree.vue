<template>
    <div>
        <div class="modal fade modal-info" id="add_customer">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="voyager-people"></i> Add Customer</h4>
                    </div>

                    <div class="modal-body">
                        <add-edit-customer></add-edit-customer>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <TreeChart :json="g_tree.tree_data" v-on:fetch-node="fetchNewNode($event)" />
            </div>
        </div>
        <BlockUI :html="loader.html" :message="loader.msg" v-if="loader.block === true"></BlockUI>
    </div>
</template>

<script>

    import TreeChart from "../../plugin/tree-chart/TreeChart";
    import {mapActions, mapState} from "vuex";

    export default {
        components: {
            TreeChart
        },
        methods: {
            ...mapActions([
                'fetchGenealogyTree'
            ]),
            showModal(){
                $('#add_customer').modal('show');
            },
            // fetchNewNode(treeData){
            //     this.fetchGenealogyTree(treeData.user_id);
            // }
        },
        computed: {
            ...mapState({
                loader: function (state) {
                    return state.loader;
                },
                g_tree: (state)=>{
                    return state.genealogy_tree;
                }
            })
        },
        mounted() {
            this.fetchGenealogyTree();
            // this.fetchAvailableProducts();
        },
    }
</script>
<style>
    .node .person .avat{
        border: none !important;
        background: none !important;
    }
</style>
