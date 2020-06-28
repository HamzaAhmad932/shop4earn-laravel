let actions = {

    fetchGenealogyTree: async ({commit}, user_id = null) => {
        commit('SHOW_LOADER', null, {root: true});

        axios({
            url: '/v1/get-genealogy-tree',
            method: 'POST',
            data: { user_id }
        }).then((resp) => {
            commit('SET_GENEALOGY_TREE', resp.data.data);
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
                                error_message[k2] = validation_errors[k2][0];
                                error_status[k2] = true;
                            }
                        }
                    }
                }
            }
            commit('SET_SEARCH_ERRORS', {error_message, error_status});
            commit('HIDE_LOADER', null, {root: true});
        });

    },

    fetchGenealogyTreeChild: async ({commit}, user_id = null) => {
        commit('SHOW_LOADER', null, {root: true});
        return new Promise((resolve, reject) => {
            axios({
                url: '/v1/get-genealogy-tree',
                method: 'POST',
                data: { user_id }
            }).then((resp) => {
                resolve(resp.data.data);
                commit('HIDE_LOADER', null, {root: true});
            }).catch((err) => {
                commit('HIDE_LOADER', null, {root: true});
                console.log(err);
            });

        });
    },
};


export default actions;
