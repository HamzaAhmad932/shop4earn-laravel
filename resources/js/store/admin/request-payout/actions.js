import store from "../../index";

let actions = {

    fetchAllPayoutRequests: async ({commit, state}, page = 1) => {

        commit('SHOW_LOADER', null, {root: true});
        commit('SET_Filter_PAGE',  page, {root: true});
        commit('SET_Filter_RELATIONS', [], {root: true});

        commit('SET_Filter_SEARCH_IN_COLUMMN',
            ['user_id'],
            {root: true}
        );

        axios({
            url: '/v1/fetch-all-payout-requests',
            method: 'POST',
            data: {'filters': store.state.filter},
        }).then((resp) => {
            commit('SET_ALL_PAYOUT_REQUESTS', resp.data);
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });
    },

    fetchAllPaymentMethods: async ({commit, state})=> {

        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/fetch-all-payment-method',
            method: 'GET',
        }).then((resp) => {
            commit('SET_PAYMENT_METHOD', resp.data.data);
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });
    },

    changeStatus: async ({commit, state, dispatch}, data)=> {

        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/update-payout-request-status',
            method: 'POST',
            data
        }).then((resp) => {
            if(resp.data.status){
                toastr.success(resp.data.message);
                dispatch('fetchAllPayoutRequests');
            }else{
                toastr.error(resp.data.message);
            }
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });
    },

    addPayoutRequest: async ({commit, state})=>{

        commit('SHOW_LOADER', null, {root: true});

        await axios({
            url: '/v1/add-payout-request',
            method: 'POST',
            data : state.add_payout
        }).then((resp) => {

            if (resp.data.status) {
                toastr.success(resp.data.message);
                window.location.href = '/portal/request-payout';
            }
            commit('HIDE_LOADER', null, {root: true});
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
                                //console.log(k2 +' -- ' + validation_errors[k2][0]);
                                error_message[k2] = validation_errors[k2][0];
                                error_status[k2] = true;
                            }
                        }
                    }
                }
            }
            commit('SET_ADD_PAYOUT_ERRORS', {error_message, error_status});
            commit('HIDE_LOADER', null, {root: true});
        });
    }
};


export default actions;
