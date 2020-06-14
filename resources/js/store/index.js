import Vue from 'vue';
import Vuex from 'vuex';
import customers from './admin/customers/index';
import genealogy_tree from './admin/genealogy-tree/index';
import payouts from './admin/request-payout/index';
import dashboard from './admin/dashboard/index';
import cart from './web/cart/index';
import checkout from './web/checkout/index';
import state from "./root_state";
import mutations from "./root_mutations";
import actions from "./root_actions";

Vue.use(Vuex);
export default new Vuex.Store({
    state,
    actions,
    mutations,
    modules: {
        customers,
        genealogy_tree,
        payouts,
        dashboard,
        cart,
        checkout
    }
});
