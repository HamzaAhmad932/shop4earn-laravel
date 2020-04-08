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
                <div class="row">
                    <div class="col-lg-8 text-right">
                        <div class="invalid-feedback" v-if="g_tree.search.error_status.user_id">{{g_tree.search.error_message.user_id}}</div>
                    </div>
                    <div class="col-lg-4">
                        <form class="form-inline my-2 my-lg-0">
<!--                            <select name="" id="" class="form-control">-->
<!--                                <option value="user_id" selected>User ID</option>-->
<!--                            </select>-->
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="g_tree.search.query">
                            <button class="btn btn-outline-success my-2 my-sm-0" @click.prevent="applySearch()">Search</button>
                            <button class="btn btn-outline-success my-2 my-sm-0" @click.prevent="resetSearch()">Reset</button>
                        </form>
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
            applySearch(){
                this.fetchGenealogyTree(this.g_tree.search.query);
            },
            resetSearch(){
                this.fetchGenealogyTree();
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
                },
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
