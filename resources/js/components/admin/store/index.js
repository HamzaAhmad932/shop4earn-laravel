import Vuex from 'vuex';
import customers from './customers/index';
import state from "./root_state";
import mutations from "./root_mutations";

export default new Vuex.Store({
    state,
    mutations,
    modules: {
        customers,
    }
});
