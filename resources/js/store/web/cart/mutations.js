let mutations = {

    SET_CART_CONTENT(state, payload){
        state.cart_content = payload.cart_content;
        state.totals = payload.totals;
    }
};

export default mutations;
