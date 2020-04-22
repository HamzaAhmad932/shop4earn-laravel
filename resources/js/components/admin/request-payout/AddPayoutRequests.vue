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
                                        <label>Payment Method &nbsp;
                                            <span class="invalid-feedback" v-if="add_payout.error_status.pm_id">
                                                * {{add_payout.error_message.pm_id}}
                                            </span>
                                        </label>
                                        <v-select :options="payment_methods" :reduce="payment_methods => payment_methods.code" label="label" v-model="add_payout.pm_id"></v-select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Amount&nbsp;
                                            <span class="invalid-feedback" v-if="add_payout.error_status.amount">
                                                {{add_payout.error_message.amount}}
                                            </span>
                                        </label>
                                        <v-select :options="available_amount" :reduce="available_amount => available_amount.code" label="label" v-model="add_payout.amount"></v-select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Phone&nbsp;
                                            <span class="invalid-feedback" v-if="add_payout.error_status.phone">
                                                * {{add_payout.error_message.phone}}
                                            </span>
                                        </label>
                                        <input type="number" v-model="add_payout.phone" class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Password&nbsp;
                                            <span class="invalid-feedback" v-if="add_payout.error_status.password">
                                                * {{add_payout.error_message.password}}
                                            </span>
                                        </label>
                                        <input type="password" v-model="add_payout.password" class="form-control">
                                    </div>

                                    <div class="col-md-12 float-right mr-3">
                                        <a href="#" @click.prevent="addPayoutRequest()"
                                           class="btn btn-success btn-add-new float-right">
                                            <i class="voyager-plus"></i> <span>Place Request</span>
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
                available_amount: (state) => {
                    return state.payouts.available_amount;
                },
                add_payout: (state) => {
                    return state.payouts.add_payout;
                },
            })
        }
    }
</script>
