
let actions = {

    getCartContent: async ({commit})=> {

        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/get-shopping-cart-content',
            method: 'GET',
        }).then((resp) => {
            commit('SET_CART_CONTENT', resp.data);
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });
    },

    updateQty : async ({commit}, updated_content)=> {

        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/update-shopping-cart-content',
            method: 'POST',
            data: updated_content
        }).then((resp) => {
            commit('SET_CART_CONTENT', resp.data);
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });
    },

    deleteCartItem : async ({commit}, row_id)=> {

        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/delete-shopping-cart-item',
            method: 'POST',
            data: {row_id}
        }).then((resp) => {
            commit('SET_CART_CONTENT', resp.data);
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });
    },


};

export default actions;
