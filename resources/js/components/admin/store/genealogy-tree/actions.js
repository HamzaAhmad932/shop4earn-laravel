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
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });

    },
};


export default actions;
