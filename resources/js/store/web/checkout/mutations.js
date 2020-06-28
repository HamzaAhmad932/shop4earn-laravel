let mutations = {
    SET_REGISTRATION_ERRORS(state, payload){
        return state.register = {...state.register, ...payload};
    },

    SET_USER_ID_AND_USER_NAME(state, payload){
        state.register.user_id = payload.data.mx_id;
        state.register.name = 'User'+payload.data.mx_id.toString();
        return state;
    },

    REGISTER_GENERAL_ERROR(state, {message, status}){
        state.register.general_error = message;
        state.register.general_status = status;
        return state;
    }
};


export default mutations;
