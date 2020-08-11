<template>
    <div v-if="dashboard">
        <div class="container-fluid-header">
            <div class="card min-height-150">
                <div class="card-body" style="line-height: 35px; margin-top: 15px; padding: 20px !important;">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-xs-6 mb-0-important">
                            <h4>Welcome {{dashboard.user.name}}</h4>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 mb-0-important text-right">
                            <strong class="badge badge-success">{{dashboard.rank}}</strong>
                            <p class="text-muted">Current Rank</p>

                        </div>
                        <div class="col-lg-4 col-sm-12 col-xs-12 mb-0-important" v-if="dashboard.upcoming_rank">
                            <div class="panel panel-primary"><div class="panel-body text-primary"><strong>Upcomming Rank : {{dashboard.upcoming_rank}} </strong></div></div>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-xs-12 mb-0-important" v-else>
                            <div class="panel panel-info"><div class="panel-body text-info"><strong>Congratulation, You are at highest rank </strong></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="row p-top-10">
                <div class="col-lg-5">
                    <div class="row p-lf-tp">
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body box-1">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.referral}}</h1>
                                    <p class="card-text">Referral Downlines</p>
<!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.total_earned}}</h1>
                                    <p class="card-text">Total Earned (Rs.)</p>
<!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-lf-tp">
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.cf}}</h1>
                                    <p class="card-text">Carry Forward {{dashboard.cf_pos}}</p>
<!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body box-2">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.withdrawn}}</h1>
                                    <p class="card-text">Total Withdrawn (Rs.)</p>
<!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-sm-3 col-xs-3 icon-size-42 mb-0-important">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="col-lg-9 col-sm-9 col-xs-9 mb-0-important text-center">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.balance}}</h1>
                                    <p class="card-text">Available Balance (Rs.)</p>
<!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body" id="graph-body">
                            <apexchart type="donut" :options="donut.options" :series="donut.series"></apexchart>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-lg-5" v-if="dashboard.reward_list != null">
                    <div class="card">
                        <div class="card-body" id="graph-body">
                            <h2>Team Bonus Rewards</h2>
                            <br>
                            <div v-for="rl in dashboard.reward_list">
                                Reward Amount: {{rl.reward_amount}}, Target Amount: {{rl.target_amount}}
                                <div class="progress" >
                                    <div class="progress-bar progress-bar-success" role="progressbar" :aria-valuenow="rl.percentage" aria-valuemin="0" aria-valuemax="100" :style="'width:'+rl.percentage+'%'">
                                        {{rl.title}}-{{rl.percentage + '%'}}
                                    </div>
                                </div>
                            </div>
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
                    return state.dashboard.customer_dashboard;
                },
                donut: (state) =>{
                    return {
                        options: {
                            chart: {
                                id: 'graph-donut',
                                height: 310
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '78%'
                                    }
                                }
                            },
                            labels: state.dashboard.customer_dashboard.label,
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
                        series: state.dashboard.customer_dashboard.series
                    }
                },
            })
        },
        mounted() {
            this.fetchDashboardData();
        },
    }
</script>
<style scoped>
    h1{
        margin: 0 !important;
    }
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
        color: #7266ba;
    }
    .box-1{
        color: #f4f3f9;
        background-color: #7266ba;
    }
    .box-2{
        color: #dcf2f8;
        background-color: #23b7e5;
    }
    .box-3{
        background: #716ACA;
        color: #FFFFFF;
    }
    .card-body{
        padding: 10px 0 10px 15px !important;
    }
    .card-text{
        margin: 0 !important;
    }
    .text-dark-dk {
        color: #2f3342 !important;
    }
    .font-weight-600{
        font-weight: 600;
    }
    .font-weight-300{
        font-weight: 300;
    }
    .font-weight-500{
        font-weight: 500;
    }
    .font-size-16{
        font-size: 16px;
    }
    .container-fluid-header{
        padding-right: 0;
        padding-left: 0;
        margin-right: auto;
        margin-left: auto;
    }
    .mb-5-important{
        margin-bottom: 5px !important;
    }
    .min-height-150{
        min-height: 150px;
    }
    @media only screen and (max-width: 375px) {
        #graph-body{
            padding: 0 !important;
        }
    }
</style>
