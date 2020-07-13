let actions = {

    fetchDashboardCustomerData: async ({commit}) => {
        commit('SHOW_LOADER', null, {root: true});

        await axios({
            url: '/v1/get-dashboard-data',
            method: 'GET',
        }).then((resp) => {
            if(resp.data.is_customer){
                commit('SET_DASHBOARD_CLIENT_DATA', resp.data);
            }else{
                commit('SET_DASHBOARD_ADMIN_DATA', resp.data);
            }
            commit('HIDE_LOADER', null, {root: true});
        }).catch((err) => {
            commit('HIDE_LOADER', null, {root: true});
            console.log(err);
        });

    },
};

export default actions;
