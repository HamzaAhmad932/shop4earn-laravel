import {getAddCustomerInitial} from './state';

let mutations = {

    SET_ADD_CUSTOMER_ERRORS(state, payload){
        return state.add_customer = {...state.add_customer, ...payload};
    },

    SET_ADD_CUSTOMER(state, payload){
        return state.add_customer = {...state.add_customer, ...payload.data.data};
    },

    RESET_ADD_CUSTOMER_FORM(state){
        return state.add_customer = {...state.add_customer, ...getAddCustomerInitial};
    },

    SET_ALL_CUSTOMERS(state, payload){
        return state.customers = {...state.customers, ...payload.data.data};
    },

    AVAILABLE_PRODUCTS(state, payload){
         return state.products = payload.data.data;
    },

    SET_AVAILABLE_SPONSORS_AND_PRODUCTS(state, payload){
        state.sponsors = payload.data.sponsors;
        state.products = payload.data.products;
        state.add_customer.user_id = payload.data.mx_id;
        state.add_customer.name = 'User'+payload.data.mx_id.toString();
        return state;
    },
    SET_DIRECT_SPONSOR(state, payload){
        return state.direct_sponsor = payload;
    }
};

export default mutations;
