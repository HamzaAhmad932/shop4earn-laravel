let actions = {
    setFilterSort: async ({commit, state}, column) => {
        commit('SET_FILTER_SORT', column, {root: true});
    },
};

export default actions;

