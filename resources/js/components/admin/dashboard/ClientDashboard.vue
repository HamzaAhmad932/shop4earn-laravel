<template>
    <div>
        <div class="page-content" v-if="dashboard">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-0-important">
                            <h4>Welcome {{dashboard.user.name}}</h4>
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
                                <div class="col-lg-6 mb-0-important" v-else>
                                    <div class="panel panel-info"><div class="panel-body text-info"><strong>Congratulation, You are at highest rank </strong></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-top-10">
                <div class="col-lg-8">
                    <div class="row p-lf-tp">
                        <div class="col-lg-4">
                            <div class="card box-1">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.referral}}</h5>
                                    <p class="card-text">Referral Downlines</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.total_earned}}</h5>
                                    <p class="card-text">Total Earned (Rs.)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card box-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.sb}}</h5>
                                    <p class="card-text">Sales Bonus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-lf-tp">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.cf}}</h5>
                                    <p class="card-text">Carry Forward</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card box-2">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.withdrawn}}</h5>
                                    <p class="card-text">Commission Withdrawn (Rs.)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.tb}}</h5>
                                    <p class="card-text">Team Bonus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2 icon-size-42 mb-0-important">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <div class="col-lg-10 mb-0-important">
                                            <h5 class="card-title">{{dashboard.balance}}</h5>
                                            <p class="card-text">Available Balance (Rs.)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <apexchart type="donut" height="370" :options="donut.options" :series="donut.series"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BlockUI :html="loader.html" :message="loader.msg" v-if="loader.block === true"></BlockUI>
    </div>
</template>
<script>
    import VueApexCharts from 'vue-apexcharts';
    import {mapState, mapActions} from 'vuex';

    export default {
        components: {
          apexchart: VueApexCharts
        },
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
                    return state.dashboard.dashboard_data;
                },
                donut: (state) =>{
                    return {
                        options: {
                            chart: {
                                id: 'graph-donut'
                            },
                            labels: state.dashboard.dashboard_data.label,
                            title: {
                                text: "Down-line Members",
                                align: 'center'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },
                        series: state.dashboard.dashboard_data.series
                    }
                },
            })
        },
        mounted() {
            this.fetchDashboardData();
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

    .icon-size-42{
        font-size: 42px;
    }
    .box-1{
        background: #008FFB;
        color: #FFFFFF;
    }
    .box-2{
        background: #00E396;
        color: #FFFFFF;
    }
    .box-3{
        background: #716ACA;
        color: #FFFFFF;
    }
</style>
