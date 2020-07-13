let mutations = {

    SET_DASHBOARD_CLIENT_DATA(state, payload){
        return state.dashboard_data = {...state.dashboard_data, ...payload};
    },

    SET_DASHBOARD_ADMIN_DATA(state, payload){
        return state.admin_dashboard = {...state.admin_dashboard, ...payload};
    },
};
export default mutations;
