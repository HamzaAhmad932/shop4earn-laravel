let actions = {

    addCustomer: async ({commit, state, dispatch}) => {

        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/save-customer',
            method: 'POST',
            data: state.add_customer,
        }).then((resp) => {
            commit('HIDE_LOADER', null, {root: true});

            if (resp.data.status){
                toastr.success(resp.data.message);
                //window.location.href = '/portal/customers';
                commit('RESET_ADD_CUSTOMER_FORM');
                dispatch('fetchAvailableSponsorsAndProducts');
                dispatch('fetchGenealogyTree');
                $('#add_customer').modal('hide');
            }else{
                toastr.error(resp.data.message);
            }
        }).catch((err) => {
                let errors = err.response;
                let error_message = {};
                let error_status = {};
                if (errors.status == 422) {
                    if (errors.data) {
                        for (let k1 in errors.data) {
                            if (typeof errors.data[k1] == "object") {
                                let validation_errors = errors.data[k1];
                                for (let k2 in validation_errors) {
                                    error_message[k2] = validation_errors[k2][0];
                                    error_status[k2] = true;
                                }
                            }
                        }
                    }
                }
                commit('SET_ADD_CUSTOMER_ERRORS', {error_message, error_status});
                commit('HIDE_LOADER', null, {root: true});
            });
    },


    fetchAvailableSponsorsAndProducts: async ({commit}, parent_id) => {
        commit('SHOW_LOADER', null, {root: true});
        axios({
            url: '/v1/get-available-sponsors-and-products',
            method: 'POST',
            data : {parent_id}
        }).then((resp) => {
            commit('SET_AVAILABLE_SPONSORS_AND_PRODUCTS', resp.data);
            commit('SET_USER_ID_AND_USER_NAME', resp.data);
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });

    },

};

export default actions;
