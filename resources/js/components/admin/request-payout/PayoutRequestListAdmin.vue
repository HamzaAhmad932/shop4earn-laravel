<template>
    <div>
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="dataTable_length"><label>Show
                            <select name="dataTable_length" v-model="filter.recordsPerPage" @change="fetchAllPayoutRequests(1)" class="form-control input-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> entries</label></div>
                    </div>
                    <div class="col-sm-6">
                        <div id="dataTable_filter" class="dataTables_filter">
                            <label>Search:
                                <input type="search" v-model="filter.search.searchStr" @keyup="fetchAllPayoutRequests(1)" class="form-control input-sm" placeholder="Search..">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTable" class="table table-hover dataTable no-footer" role="grid"
                               aria-describedby="dataTable_info">
                            <thead>
                            <tr role="row">
                                <th :class="getSortClass('id')" @click="sort('id')">ID</th>
                                <th :class="getSortClass('user_id')" @click="sort('user_id')">User ID</th>
                                <th :class="getSortClass('amount')" @click="sort('amount')">Amount</th>
                                <th :class="getSortClass('admin_percentage')" @click="sort('admin_percentage')">Admin Percentage</th>
                                <th :class="getSortClass('admin_charges')" @click="sort('admin_charges')">Admin Charges</th>
                                <th :class="getSortClass('donation')" @click="sort('donation')">Donation</th>
                                <th :class="getSortClass('phone')" @click="sort('phone')">Phone</th>
                                <th :class="getSortClass('status')" @click="sort('status')">Status</th>
                                <th :class="getSortClass('date_requested')"   @click="sort('date_requested')">Date Requested</th>
                                <th :class="getSortClass('date_cleared')" @click="sort('date_cleared')">Date Cleared</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="odd" v-for="payout in payout_list.data">
                                <td class="no-sort no-click" >{{payout.id}}</td>
                                <td class="no-sort no-click" >{{payout.user_id}}</td>
                                <td class="no-sort no-click" >{{payout.amount}}</td>
                                <td class="no-sort no-click" >{{payout.admin_percentage}}</td>
                                <td class="no-sort no-click" >{{payout.admin_charges}}</td>
                                <td class="no-sort no-click" >{{payout.donation}}</td>
                                <td class="no-sort no-click" >{{payout.phone}}</td>
                                <td class="no-sort no-click" ><span :class="payout.status_info.class">{{payout.status_info.status}}</span></td>
                                <td class="no-sort no-click" >{{payout.date_requested}}</td>
                                <td class="no-sort no-click" >{{payout.date_cleared}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Update status
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <p><a class="dropdown-item" href="#" @click.prevent="changeStatus({status: 1, request_id: payout.id})">Paid</a></p>
                                            <p><a class="dropdown-item" href="#" @click.prevent="changeStatus({status: 0, request_id: payout.id})">Pending</a></p>
                                            <p><a class="dropdown-item" href="#" @click.prevent="changeStatus({status: 2, request_id: payout.id})">Rejected</a></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_info" v-if="payout_list.meta !== undefined" id="dataTable_info" role="status" aria-live="polite">
                            Showing {{payout_list.meta.from > 0 ? payout_list.meta.from: 0}} to {{payout_list.meta.to  > 0 ? payout_list.meta.to : 0}} of {{payout_list.meta.total}} entries
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                            <ul class="pagination">
                                <pagination :data="payout_list" @pagination-change-page="fetchAllPayoutRequests"></pagination>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <h4 v-for="customer in customers"> {{customer.id}} - {{customer.name}}</h4>-->
    </div>
</template>
<script>

    import {mapActions, mapState,} from 'vuex';

    export default {
        data() {
            return {}
        },
        methods: {
            ...mapActions([
                'fetchAllPayoutRequests',
                'setFilterSort',
                'changeStatus',
            ]),
            getSortClass(column){
                let _class = 'sorting';
                if (this.filter.sort.sortColumn == column) {
                    _class = (
                        this.filter.sort.sortOrder.toLowerCase() == 'desc'
                            ? 'sorting_desc'
                            : 'sorting_asc'
                    );
                }
                return _class;
            },
            sort(column){
                this.setFilterSort(column);
                this.fetchAllPayoutRequests(1);
            },
        },

        computed: {
            ...mapState({
                loader: function (state) {
                    return state.loader;
                },
                filter: function (state) {
                    return state.filter;
                },
                payout_list: (state) => {
                    return state.payouts.payout_list;
                },
            })
        },
        mounted() {
            this.fetchAllPayoutRequests(1);
        },
    }
</script>
<style scoped>
    .dropdown-item {
        width: 100%;
        padding: .25rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }
</style>
