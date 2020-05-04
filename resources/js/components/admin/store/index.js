import Vuex from 'vuex';
import customers from './customers/index';
import genealogy_tree from './genealogy-tree/index';
import payouts from './request-payout/index';
import dashboard from './dashboard/index';
import state from "./root_state";
import mutations from "./root_mutations";
import actions from "./root_actions";

export default new Vuex.Store({
    state,
    actions,
    mutations,
    modules: {
        customers,
        genealogy_tree,
        payouts,
        dashboard
    }
});
