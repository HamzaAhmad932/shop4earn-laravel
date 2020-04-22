let mutations = {
    SET_ALL_PAYOUT_REQUESTS(state, payload){
        return state.payout_list = payload;
    },

    SET_SEARCH_ERRORS(state, payload){
        return state.search = {...state.search, ...payload};
    },

    SET_PAYMENT_METHOD(state, payload){
        return state.payment_methods = payload;
    },

    SET_ADD_PAYOUT_ERRORS(state, payload){
        return state.add_payout = {...state.add_payout, ...payload};
    },
};


export default mutations;
