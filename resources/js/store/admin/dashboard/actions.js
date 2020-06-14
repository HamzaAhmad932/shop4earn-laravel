let actions = {

    fetchDashboardData: async ({commit}) => {
        commit('SHOW_LOADER', null, {root: true});

        await axios({
            url: '/v1/get-dashboard-data',
            method: 'GET',
        }).then((resp) => {
            commit('SET_DASHBOARD_DATA', resp.data);
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });

    },
};

export default actions;
