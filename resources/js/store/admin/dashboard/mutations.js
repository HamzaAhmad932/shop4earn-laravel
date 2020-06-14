let mutations = {

    SET_DASHBOARD_DATA(state, payload){
        return state.dashboard_data = {...state.dashboard_data, ...payload};
    },
};
export default mutations;
