let mutations = {
    SET_ALL_PAYOUT_REQUESTS(state, payload){
        return state.payout_list = payload;
    },

    SET_SEARCH_ERRORS(state, payload){
        return state.search = {...state.search, ...payload};
    },

    SET_PAYMENT_METHOD(state, payload){
        state.payment_methods = payload.payment_methods;
        state.add_payout.phone = payload.phone;
        state.admin_percentage = parseFloat(payload.admin_percentage);
        state.balance = payload.balance;
        return state;
    },

    SET_ADD_PAYOUT_ERRORS(state, payload){
        return state.add_payout = {...state.add_payout, ...payload};
    },
};


export default mutations;
