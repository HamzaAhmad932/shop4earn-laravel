<template>
    <div>
        <div class="page-content" v-if="dashboard">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-0-important">
                            <h4>Overview</h4>
                        </div>
                        <div class="col-lg-6 mb-0-important">
                            <div class="row">
                                <div class="col-lg-6 mb-0-important">
                                    <strong>{{dashboard.rank}}</strong>
                                    <p class="text-muted">Current Rank</p>
                                </div>
                                <div class="col-lg-6 mb-0-important" v-if="dashboard.upcoming_rank">
                                    <div class="panel panel-primary"><div class="panel-body text-primary"><strong>Upcomming Rank : {{dashboard.upcoming_rank}} </strong></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-top-10">
                <div class="col-lg-5">
                    <div class="row p-lf-tp">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.referral}}</h5>
                                    <p class="card-text">Referral Downlines</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.balance}}</h5>
                                    <p class="card-text">Balance (available)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-lf-tp">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">$323</h5>
                                    <p class="card-text">Earning</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">$323</h5>
                                    <p class="card-text">Earning</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            interactive graphs and analytics will be available soon...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import {mapState, mapActions} from 'vuex';

    export default {
        data(){
            return {

            }
        },
        methods: {
          ...mapActions([
              'fetchDashboardData'
          ])
        },
        computed: {
            ...mapState({
                loader: function (state) {
                    return state.loader;
                },
                dashboard: function(state){
                    console.log(state.dashboard);
                    return state.dashboard.dashboard_data;
                },
            })
        },
        mounted() {
            this.fetchDashboardData();
            console.log(this.dashboard);
        },
    }
</script>
<style>
    .p-lf-tp{
        padding-left: 10px;
    }

    .p-top-10{
        padding-top: 10px;
    }
    .min-width-100{
        min-width: 100%;
    }

    .alert-custom-1{
        background-color: #ffffff;
        /*border-color: ;*/
    }
    .mb-0-important{
        margin-bottom: 0 !important;
    }
</style>
