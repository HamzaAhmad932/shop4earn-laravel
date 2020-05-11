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
                <div class="col-lg-6">
                    <div class="row p-lf-tp">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-600 text-dark-dk">Referral Downlines</h5>
                                    <p class="card-text text-muted">Members referred by you</p>
                                    <p class="font-weight-600 text-dark-dk font-size-16">{{dashboard.referral}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-600 text-dark-dk">Total Earned (Sales Bonus + Team Bonus)</h5>
                                    <p class="card-text text-muted">Commissions and bonuses</p>
                                    <p class="font-weight-600 text-dark-dk font-size-16">{{dashboard.total_earned}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-lf-tp">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-600 text-dark-dk">Carry Forward</h5>
                                    <p class="card-text text-muted">Points carried forward from a side</p>
                                    <p class="font-weight-600 text-dark-dk font-size-16">{{dashboard.cf}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-600 text-dark-dk">Commission Withdrawn (Rs.)</h5>
                                    <p class="card-text text-muted">Withdrawn amount</p>
                                    <p class="font-weight-600 text-dark-dk font-size-16">{{dashboard.withdrawn}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-sm-2 icon-size-42 mb-0-important">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="col-lg-10 col-sm-10 mb-0-important">
                                    <h5 class="card-title font-weight-600 text-dark-dk">Available Balance (Rs.)</h5>
                                    <p class="card-text text-muted">Current Balance</p>
                                    <p class="font-weight-600 text-dark-dk font-size-16">{{dashboard.balance}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body" id="graph-body">
                            <apexchart type="donut" :options="donut.options" :series="donut.series"></apexchart>
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
                                id: 'graph-donut',
                                height: 415
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '78%'
                                    }
                                }
                            },
                            labels: state.dashboard.dashboard_data.label,
                            title: {
                                text: "Down-line Members",
                                align: 'center'
                            },
                            legend: {
                                position: 'bottom'
                            },
                            responsive: [
                                {
                                    breakpoint: 375,
                                    options: {
                                        chart: {
                                            width: 260,
                                            height: 300
                                        },
                                        legend: {
                                            position: "bottom"
                                        }
                                    }
                                }
                            ]
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
    .card-body{
        padding: 10px !important;
    }
    .text-dark-dk {
        color: #2f3342 !important;
    }
    .font-weight-600{
        font-weight: 600;
    }
    .font-weight-500{
        font-weight: 500;
    }
    .font-size-16{
        font-size: 16px;
    }
    @media only screen and (max-width: 375px) {
        #graph-body{
            padding: 0 !important;
        }
    }
</style>
