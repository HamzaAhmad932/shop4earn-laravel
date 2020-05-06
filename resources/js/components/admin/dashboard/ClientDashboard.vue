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
                                    <p class="card-text">Available Balance (Rs.)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-lf-tp">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.cf}}</h5>
                                    <p class="card-text">Carry Forward</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.withdrawn}}</h5>
                                    <p class="card-text">Commission Withdrawn (Rs.)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{dashboard.total_earned}}</h5>
                                    <p class="card-text">Total Earned (Rs.)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <apexchart type="area" height="338" :options="area_graph.chartOptions" :series="area_graph.series"></apexchart>
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
                area_graph: function (state) {
                    return {
                        series: [{
                            name: 'Left',
                            data: [31, 40, 28, 51, 42, 109, 100]
                        }, {
                            name: 'Right',
                            data: [11, 32, 45, 32, 34, 52, 41]
                        }],
                        chartOptions: {
                            chart: {
                                height: 350,
                                type: 'area'
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth'
                            },
                            xaxis: {
                                type: 'datetime',
                                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                            },
                            tooltip: {
                                x: {
                                    format: 'dd/MM/yy HH:mm'
                                },
                            },
                        },
                    }
                }
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
</style>
