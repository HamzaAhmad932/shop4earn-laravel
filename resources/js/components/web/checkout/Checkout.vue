<template>
    <div>
        <!-- customer login start -->
        <div class="customer_login mt-60">
            <div class="container">
                <div class="row">
                    <!--register area start-->
                    <div class="col-lg-12 col-md-12">
                        <div class="account_form register">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <h2>Register & Checkout</h2>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <span class="invalid-feedback-3" v-if="register.general_status">{{register.general_error}}</span>
                                </div>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <label>Sponsor ID (optional) </label>
                                        <input type="number" v-model="register.sponsor_id">
                                        <div class="invalid-feedback-2" v-if="register.error_status.sponsor_id">{{register.error_message.sponsor_id}}</div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <label>Position</label>
                                        <select name="position" id="position" v-model="register.position">
                                            <option value="1" selected>Left</option>
                                            <option value="2">Right</option>
                                        </select>
                                        <div class="invalid-feedback-2" v-if="register.error_status.position">{{register.error_message.position}}</div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>User ID</label>
                                        <input type="text" v-model="register.user_id" disabled>
                                        <div class="invalid-feedback-2" v-if="register.error_status.user_id">{{register.error_message.user_id}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Email address  <span>*</span></label>
                                        <input type="text" v-model="register.email">
                                        <div class="invalid-feedback-2" v-if="register.error_status.email">{{register.error_message.email}}</div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Phone <span>*</span></label>
                                        <input type="text" v-model="register.phone">
                                        <div class="invalid-feedback-2" v-if="register.error_status.phone">{{register.error_message.phone}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Username  <span>*</span></label>
                                        <input type="text" v-model="register.name">
                                        <div class="invalid-feedback-2" v-if="register.error_status.name">{{register.error_message.name}}</div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>City <span>*</span></label>
                                        <input type="text" v-model="register.city">
                                        <div class="invalid-feedback-2" v-if="register.error_status.city">{{register.error_message.city}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Password  <span>*</span></label>
                                        <input type="password" v-model="register.password">
                                        <div class="invalid-feedback-2" v-if="register.error_status.password">{{register.error_message.password}}</div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Confirm Password <span>*</span></label>
                                        <input type="password" v-model="register.password_confirmation">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="login_submit">
                                            <button @click.prevent="registerAttempt()">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--register area end-->
                </div>
            </div>
        </div>
        <!-- customer login end -->
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';

    export default {
        mounted() {
            this.fetchAvailableSponsorsAndProducts();
        },
        methods: {
          ...mapActions([
              'registerAttempt',
              'fetchAvailableSponsorsAndProducts'
          ])
        },

        computed: {
            ...mapState({
                register: function (state) {
                    return state.checkout.register;
                }
            })
        }
    }
</script>
<style>
    #position{
        border: 1px solid #ebebeb;
        height: 40px;
        max-width: 100%;
        padding: 0 20px;
        background: none;
        width: 100%;
    }
    .invalid-feedback-2{
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
    }

    .invalid-feedback-3{
        width: 100%;
        margin-top: .25rem;
        /*font-size: 80%;*/
        color: #dc3545;
    }
</style>
