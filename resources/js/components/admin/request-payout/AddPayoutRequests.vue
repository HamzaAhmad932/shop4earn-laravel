<template>
    <div>
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-milestone"></i> New Payout Request
            </h1>
        </div>

        <div class="page-content browse container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Amount&nbsp;&nbsp;(Available Balance: Rs.{{balance}})
                                            <span class="invalid-feedback" v-if="add_payout.error_status.amount">
                                               * {{add_payout.error_message.amount}}
                                            </span>
                                        </label>
                                        <v-select :options="available_amount" :reduce="available_amount => available_amount.code" label="label" v-model="add_payout.amount"></v-select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Payment Method&nbsp;
                                            <span class="invalid-feedback" v-if="add_payout.error_status.pm_id">
                                                * {{add_payout.error_message.pm_id}}
                                            </span>
                                        </label>
                                        <v-select :options="payment_methods" :reduce="payment_methods => payment_methods.code" label="label" v-model="add_payout.pm_id"></v-select>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <label>Phone&nbsp;
                                            <span class="invalid-feedback" v-if="add_payout.error_status.phone">
                                                * {{add_payout.error_message.phone}}
                                            </span>
                                        </label>
                                        <input type="number" v-model="add_payout.phone" class="form-control" disabled>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Admin Charges&nbsp; ({{this.admin_percentage}}%)</label>
                                        <input type="text" :value="admin_percentage*(parseFloat(add_payout.amount)/100)" class="form-control" disabled>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Donation&nbsp;(By Default Rs.20)
                                            <span class="invalid-feedback" v-if="add_payout.error_status.donation">
                                                * {{add_payout.error_message.donation}}
                                            </span>
                                        </label>
                                        <input type="number" v-model="add_payout.donation" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Password&nbsp;
                                            <span class="invalid-feedback" v-if="add_payout.error_status.password">
                                                * {{add_payout.error_message.password}}
                                            </span>
                                        </label>
                                        <input type="password" v-model="add_payout.password" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Amount Payable&nbsp; (Rs.)</label>
                                        <input type="text" :value="amount_payable" class="form-control" disabled>
                                    </div>

<!--                                    <div class="col-md-6">-->
<!--                                        <div v-if="add_payout.amount !== 0">-->
<!--                                            <table class="table table-borderless">-->
<!--                                                <thead>-->
<!--                                                    <tr>-->
<!--                                                        <td>Requested Amount</td>-->
<!--                                                        <td>Admin Charges</td>-->
<!--                                                        <td>Donation</td>-->
<!--                                                        <td>Payable</td>-->
<!--                                                    </tr>-->
<!--                                                </thead>-->
<!--                                                <tbody>-->
<!--                                                    <tr>-->
<!--                                                        <td>Rs.{{add_payout.amount}}</td>-->
<!--                                                        <td>Rs.{{admin_percentage*(parseFloat(add_payout.amount)/100)}}</td>-->
<!--                                                        <td>Rs.{{add_payout.donation}}</td>-->
<!--                                                        <td>Rs.{{parseFloat(add_payout.amount)-(admin_percentage*(parseFloat(add_payout.amount)/100))-(parseFloat(add_payout.donation))}}</td>-->
<!--                                                    </tr>-->
<!--                                                </tbody>-->
<!--                                            </table>-->
<!--                                        </div>-->
<!--                                    </div>-->

                                    <div class="col-md-12 float-right mr-3">
                                        <a href="#" @click.prevent="addPayoutRequest()"
                                           class="btn btn-success btn-add-new float-right">
                                            <i class="voyager-plus"></i> Place Request
                                        </a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BlockUI :html="loader.html" :message="loader.msg" v-if="loader.block === true"></BlockUI>
    </div>
</template>
<script>
    import {mapActions, mapState} from 'vuex';
    export default {
        mounted() {
            this.fetchAllPaymentMethods();
        },
        data(){
            return{
                amount_payable: ''
            }
        },
        methods: {

            ...mapActions([
                'fetchAllPaymentMethods',
                'addPayoutRequest'
            ]),
        },
        computed: {
            ...mapState({
                loader: function (state) {
                    return state.loader;
                },
                payment_methods: (state) => {
                    return state.payouts.payment_methods;
                },
                admin_percentage: (state) => {
                    return state.payouts.admin_percentage;
                },
                available_amount: (state) => {
                    return state.payouts.available_amount;
                },
                add_payout: (state) => {
                    return state.payouts.add_payout;
                },
                balance: (state) => {
                    return state.payouts.balance;
                },
            })
        },

        watch: {
            add_payout: {
                deep: true,
                immediate: true,
                handler(new_value, old_value){

                    if(typeof new_value.amount !== "undefined" && !isNaN(new_value.amount) && new_value.amount != null){
                        let donation = this.add_payout.donation == '' || parseInt(this.add_payout.donation) < 20 ? 20 : this.add_payout.donation;
                        let amount_calculated = parseFloat(this.add_payout.amount)-(this.admin_percentage*(parseFloat(this.add_payout.amount)/100))-(parseFloat(donation));
                        this.amount_payable = parseFloat(amount_calculated) < 0 ? 0 : amount_calculated;
                    }
                }
            }
        }
    }
</script>

<style>
    .amount-display-box{
        border: 1px solid darkgrey;
        padding: 10px;
        margin-top: 20px;
    }
</style>
