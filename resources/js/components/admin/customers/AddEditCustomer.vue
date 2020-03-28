<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Sponsor <span class="text-muted">(Optional)</span></label>
                                <v-select :options="sponsors" :reduce="sponsors => sponsors.code" label="label" v-model="add_customer.sponsor_id"></v-select>
                                <div class="invalid-feedback" v-if="add_customer.error_status.sponsor_id">{{add_customer.error_message.sponsor_id}}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Position</label>
                                <v-select :options="positions" :reduce="positions => positions.code" label="label"  v-model="add_customer.position"></v-select>
                                <div class="invalid-feedback" v-if="add_customer.error_status.position">{{add_customer.error_message.position}}</div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="user_id">User ID </label>
                                <input type="email" v-model="add_customer.user_id" class="form-control" id="user_id" disabled>
                                <div class="invalid-feedback" v-if="add_customer.error_status.user_id">{{add_customer.error_message.user_id}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email">Email </label>
                                <input type="email" v-model="add_customer.email" class="form-control" id="email" placeholder="you@example.com" disabled>
                                <div class="invalid-feedback" v-if="add_customer.error_status.email">{{add_customer.error_message.email}}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="user_name">User name </label>
                                <input type="email" v-model="add_customer.name" class="form-control" id="user_name" placeholder="John doe">
                                <div class="invalid-feedback" v-if="add_customer.error_status.name">{{add_customer.error_message.name}}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label >Password (default = 123456)</label>
                                <input type="password" v-model="add_customer.password" class="form-control" id="password" placeholder="Enter Password">
                                <div class="invalid-feedback" v-if="add_customer.error_status.password">{{add_customer.error_message.password}}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label >Confirm Password </label>
                                <input type="password" v-model="add_customer.password_confirmation" class="form-control" id="confirm_password" placeholder="Confirm password">
                                <div class="invalid-feedback" v-if="add_customer.error_status.password_confirmation">{{add_customer.error_message.password_confirmation}}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city">City</label>
                                <input type="text" v-model="add_customer.city" class="form-control" id="city" placeholder="City">
                                <div class="invalid-feedback" v-if="add_customer.error_status.city">{{add_customer.error_message.city}}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone_1">Phone</label>
                                <input type="text" v-model="add_customer.mobile" class="form-control" id="phone_1" placeholder="Phone">
                                <div class="invalid-feedback" v-if="add_customer.error_status.mobile">{{add_customer.error_message.mobile}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label><strong>Product</strong> <span class="text-muted"></span>
                                </label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label><strong>Quantity</strong> <span class="text-muted"></span></label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" @click.prevent="addNewRow()" class="btn btn-success btn-add-new btn-sm">
                                    <i class="voyager-double-down"></i> <span>Add More</span>
                                </a>
                            </div>
                        </div>

                        <div class="row" v-for="(p, i) in add_customer.selected_products">
                            <div class="col-md-6 mb-3">
                                <v-select :options="products" :reduce="product => product.code" label="label" v-model="p.product_id"></v-select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="number" min="1" v-model="p.qty" class="form-control"/>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-danger btn-add-new btn-sm" @click.prevent="removeRow(i)"><i class="voyager-double-up"></i> Remove</button>
                            </div>
                        </div>

                        <div class="row mb-5 mt-5">
                            <div class="col-md-12 float-left">
                                <a href="#" @click.prevent="addCustomer()" class="btn btn-success btn-add-new">
                                    <i class="voyager-plus"></i> <span>Add Customer</span>
                                </a>
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

    import {mapState, mapActions} from 'vuex';

    export default {
        data(){
            return{

            }
        },

        methods: {
            addNewRow(){
                this.add_customer.selected_products.push({
                    product_id : '',
                    qty : 1,
                });
            },
            removeRow(i){
                if(this.add_customer.selected_products.length > 1){
                    this.add_customer.selected_products.splice(i, 1);
                }
            },
            ...mapActions([
                'addCustomer',
                'fetchAvailableSponsorsAndProducts',
                //'fetchAvailableProducts',
                //'fetchProductPrice',
                //'calculatePrice',
            ]),
        },

        computed: {
            ...mapState({
                loader: function (state) {
                    return state.loader;
                },
                add_customer: (state)=>{
                    return state.customers.add_customer;
                },
                positions: function (state) {
                    return state.customers.add_customer.positions;
                },
                sponsors: function (state) {
                    return state.customers.sponsors;
                },
                products: function (state) {
                    return state.customers.products;
                },
                parent_id: function (state) {
                    return state.customers.add_customer.parent_id;
                }
            })
        },
        watch: {
            parent_id: {
                deep: true,
                handler(new_value, old_value){
                    if(new_value !== ''){
                        this.fetchAvailableSponsorsAndProducts(new_value);
                    }else{
                        this.fetchAvailableSponsorsAndProducts();
                    }
                }
            }
        },
        mounted() {
            this.fetchAvailableSponsorsAndProducts();
            // this.fetchAvailableProducts();
        },
    }
</script>
