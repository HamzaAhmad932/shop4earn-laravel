let actions = {

    registerAttempt: async ({commit, state}) => {

        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/checkout',
            method: 'POST',
            data: state.register,
        }).then((resp) => {
            commit('HIDE_LOADER', null, {root: true});
            if (resp.data.status){
                toastr.success(resp.data.message);
                window.location.href = resp.data.data;
            }else{
                commit('REGISTER_GENERAL_ERROR', {message: resp.data.message, status: true});
                setTimeout(function () {
                    commit('REGISTER_GENERAL_ERROR', {message: '', status: false});
                }, 10000);
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
            commit('SET_REGISTRATION_ERRORS', {error_message, error_status});
            commit('HIDE_LOADER', null, {root: true});
        });
    },
};


export default actions;
