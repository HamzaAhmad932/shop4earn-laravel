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
                <div class="col-lg-6">
                    <div class="row p-lf-tp">
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body box-1">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.total_network_members}}</h1>
                                    <p class="card-text">Network Members</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.total_paid_amount}}</h1>
                                    <p class="card-text">Total Paid (Rs.)</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-lf-tp">
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.total_approved_customers}}</h1>
                                    <p class="card-text">Approved Members</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body box-2">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.total_sale}}</h1>
                                    <p class="card-text">Total Sale (Rs.)</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-lf-tp">
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body box-3">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.today_joined}}</h1>
                                    <p class="card-text">Today Joined</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.donations}}</h1>
                                    <p class="card-text">Total Donations (Rs.)</p>
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
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.profit}}</h1>
                                    <p class="card-text">Profit (Rs.)</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <apexchart type="line" :options="line.options" :series="line.series"></apexchart>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="row p-lf-tp">
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.total_sharing}}</h1>
                                    <p class="card-text">Sharing Amount (Rs.)</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.sharing_consumed}}</h1>
                                    <p class="card-text">Sharing Consumed (Rs.)</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row p-lf-tp">
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">{{dashboard.sharing_amount_balance}}</h1>
                                    <p class="card-text">Sharing Balance</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title font-weight-300 mb-5-important">-- --</h1>
                                    <p class="card-text">-- --</p>
                                    <!--                                    <p class="font-weight-600 text-dark-dk font-size-16"></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-top-10">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body" id="graph-body">
                            <div class="card-header">
                                <h3>Commission & withdrawals</h3>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Withdrawal Requests</a></li>
<!--                                <li><a data-toggle="tab" href="#menu1">Rank Overview</a></li>-->
                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="page-content page-container">
                                        <div class="padding">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">User</th>
                                                    <th scope="col">Payable Amount</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="req in dashboard.withdrawal_requests">
                                                        <td>{{req.name}}</td>
                                                        <td>{{req.payable_amount}}</td>
                                                        <td>{{req.created_at}}</td>
                                                        <td><span class="badge badge-warning">Pending</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-center">
                                                <a href="/portal/payout-requests">View all</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <h4>Rank Overview</h4>
                                    <div class="page-content page-container">
                                        <div class="padding">
                                            <div class="list list-row block">
                                                <div class="list-item" data-id="19">
                                                    <div>
                                                        <a href="#" data-abc="true"><span class="w-100 avatar gd-warning">Diamond</span></a>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <strong class="badge badge-success">5</strong>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-id="7">
                                                    <div>
                                                        <a href="#" data-abc="true"><span class="w-100 avatar gd-warning">Gold</span></a>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <strong class="badge badge-success">19</strong>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-id="17">
                                                    <div>
                                                        <a href="#" data-abc="true"><span class="w-100 avatar gd-primary">Silver</span></a>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <strong class="badge badge-success">89</strong>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-id="16">
                                                    <div>
                                                        <a href="#" data-abc="true"><span class="w-100 avatar gd-info">Standard</span></a>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <strong class="badge badge-success">23</strong>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-id="4">
                                                    <div>
                                                        <a href="#" data-abc="true"><span class="w-100 avatar gd-success">Basic</span></a>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <strong class="badge badge-success">34</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <h3>Members Information</h3>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#top_earners">Top Earners</a></li>
                                <li><a data-toggle="tab" href="#rank_overview">Rank Overview</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="top_earners" class="tab-pane fade in active">
                                    <div class="page-content page-container">
                                        <div class="padding">
                                            <div class="list list-row block">
                                                <div class="list-item" v-for="usr in dashboard.top_users">
                                                    <div>
                                                        <a href="#" data-abc="true"><span class="w-48 avatar gd-primary">
                                                            <img :src="usr.avatar" alt="."></span>
                                                        </a>
                                                    </div>
                                                    <div class="flex">
                                                        <a href="#" class="item-author text-color">{{usr.name}}</a>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <strong class="badge badge-success">{{usr.earned}}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="rank_overview" class="tab-pane fade">
                                    <h4>Rank Overview</h4>
                                    <div class="page-content page-container">
                                        <div class="padding">
                                            <div class="list list-row block">
                                                <div class="list-item" v-for="ro in dashboard.rank_overview">
                                                    <div>
                                                        <a href="#" data-abc="true"><span class="w-100 avatar" :class="ro.class_name">{{ro.rank_name}}</span></a>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <strong class="badge badge-success">{{ro.members}}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                    return state.dashboard.admin_dashboard;
                },
                line: (state) =>{

                    return {
                        options: {
                            chart: {
                                id: 'graph-line'
                            },
                            title:{
                                text: 'Sale Over Date',
                                align: 'left'
                            },
                            stroke: {
                                curve: 'smooth',
                            },
                            xaxis: {
                                categories: state.dashboard.admin_dashboard.line_graph.label
                            }
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
                        ],
                        series: [{
                            name: 'Sale',
                            data: state.dashboard.admin_dashboard.line_graph.series
                        }]
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
    .w-100{
        width: 100px !important;
        height: 43px !important;
    }

    .icon-size-42{
        font-size: 42px;
        color: #7266ba;
    }
    .flex{
        border: none !important;
    }
    .tab-content > div {
        padding: 0 !important;
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
    .voyager .nav-tabs>li.active>a:hover {
        background-color: #62a8ea;
    }
    @media only screen and (max-width: 375px) {
        #graph-body{
            padding: 0 !important;
        }
    }

    body {
        margin: 0;
    }


    a {
        color: #448bff;
        text-decoration: none;
        background-color: transparent
    }

    a:hover {
        color: #005ef7;
        text-decoration: underline
    }

    a:not([href]):not([tabindex]) {
        color: inherit;
        text-decoration: none
    }

    a:not([href]):not([tabindex]):focus,
    a:not([href]):not([tabindex]):hover {
        color: inherit;
        text-decoration: none
    }

    a:not([href]):not([tabindex]):focus {
        outline: 0
    }

    @media (min-width:576px) {
        .col-sm {
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%
        }

        .col-sm-auto {
            flex: 0 0 auto;
            width: auto;
            max-width: 100%
        }

        .col-sm-1 {
            flex: 0 0 8.3333333333%;
            max-width: 8.3333333333%
        }

        .col-sm-2 {
            flex: 0 0 16.6666666667%;
            max-width: 16.6666666667%
        }

        .col-sm-3 {
            flex: 0 0 25%;
            max-width: 25%
        }

        .col-sm-4 {
            flex: 0 0 33.3333333333%;
            max-width: 33.3333333333%
        }

        .col-sm-5 {
            flex: 0 0 41.6666666667%;
            max-width: 41.6666666667%
        }

        .col-sm-6 {
            flex: 0 0 50%;
            max-width: 50%
        }

        .col-sm-7 {
            flex: 0 0 58.3333333333%;
            max-width: 58.3333333333%
        }

        .col-sm-8 {
            flex: 0 0 66.6666666667%;
            max-width: 66.6666666667%
        }

        .col-sm-9 {
            flex: 0 0 75%;
            max-width: 75%
        }

        .col-sm-10 {
            flex: 0 0 83.3333333333%;
            max-width: 83.3333333333%
        }

        .col-sm-11 {
            flex: 0 0 91.6666666667%;
            max-width: 91.6666666667%
        }

        .col-sm-12 {
            flex: 0 0 100%;
            max-width: 100%
        }

        .order-sm-first {
            order: -1
        }

        .order-sm-last {
            order: 13
        }

        .order-sm-0 {
            order: 0
        }

        .order-sm-1 {
            order: 1
        }

        .order-sm-2 {
            order: 2
        }

        .order-sm-3 {
            order: 3
        }

        .order-sm-4 {
            order: 4
        }

        .order-sm-5 {
            order: 5
        }

        .order-sm-6 {
            order: 6
        }

        .order-sm-7 {
            order: 7
        }

        .order-sm-8 {
            order: 8
        }

        .order-sm-9 {
            order: 9
        }

        .order-sm-10 {
            order: 10
        }

        .order-sm-11 {
            order: 11
        }

        .order-sm-12 {
            order: 12
        }

        .offset-sm-0 {
            margin-left: 0
        }

        .offset-sm-1 {
            margin-left: 8.3333333333%
        }

        .offset-sm-2 {
            margin-left: 16.6666666667%
        }

        .offset-sm-3 {
            margin-left: 25%
        }

        .offset-sm-4 {
            margin-left: 33.3333333333%
        }

        .offset-sm-5 {
            margin-left: 41.6666666667%
        }

        .offset-sm-6 {
            margin-left: 50%
        }

        .offset-sm-7 {
            margin-left: 58.3333333333%
        }

        .offset-sm-8 {
            margin-left: 66.6666666667%
        }

        .offset-sm-9 {
            margin-left: 75%
        }

        .offset-sm-10 {
            margin-left: 83.3333333333%
        }

        .offset-sm-11 {
            margin-left: 91.6666666667%
        }
    }

    .text-muted {
        color: #99a0ac !important
    }

    .block,
    .card {
        background: #fff;
        border-width: 0;
        border-radius: .25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        /*margin-bottom: 1.5rem*/
    }

    .avatar {
        position: relative;
        line-height: 1;
        border-radius: 500px;
        white-space: nowrap;
        font-weight: 700;
        border-radius: 100%;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        border-radius: 500px;
        box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
    }

    .avatar img {
        border-radius: inherit;
        width: 100%
    }

    .gd-primary {
        color: #fff;
        border: none;
        background: #448bff linear-gradient(45deg, #448bff, #44e9ff)
    }

    .gd-success {
        color: #fff;
        border: none;
        background: #31c971 linear-gradient(45deg, #31c971, #3dc931)
    }

    .gd-info {
        color: #fff;
        border: none;
        background: #14bae4 linear-gradient(45deg, #14bae4, #14e4a6)
    }

    .gd-warning {
        color: #fff;
        border: none;
        background: #f4c414 linear-gradient(45deg, #f4c414, #f45414)
    }

    @media (min-width:992px) {
        .page-container {
            max-width: 1140px;
            margin: 0 auto
        }

        .page-sidenav {
            display: block !important
        }
    }

    .list {
        padding-left: 0;
        padding-right: 0
    }

    .list-item {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word
    }

    .list-row .list-item {
        -ms-flex-direction: row;
        flex-direction: row;
        -ms-flex-align: center;
        align-items: center;
        padding: .75rem .625rem
    }

    .list-row .list-item>* {
        padding-left: .625rem;
        padding-right: .625rem
    }

    .no-wrap {
        white-space: nowrap
    }

    .text-color {
        color: #5e676f
    }

    .text-gd {
        -webkit-background-clip: text;
        -moz-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        -moz-text-fill-color: transparent;
        text-fill-color: transparent
    }

    .text-sm {
        font-size: .825rem
    }

    .h-1x {
        height: 1.25rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical
    }

    .w-48 {
        width: 48px !important;
        height: 48px !important;
        overflow: hidden;
    }

    a:link {
        text-decoration: none
    }
</style>
