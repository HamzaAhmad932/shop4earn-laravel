<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <TreeChart :json="g_tree.tree_data" />
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
            ])
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
