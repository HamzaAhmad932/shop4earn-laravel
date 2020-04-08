let mutations = {
    SET_GENEALOGY_TREE(state, payload){
        return state.tree_data = payload;
    },

    SET_SEARCH_ERRORS(state, payload){
        return state.search = {...state.search, ...payload};
    }
};


export default mutations;
