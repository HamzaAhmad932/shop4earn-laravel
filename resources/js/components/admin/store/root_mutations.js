let mutations = {
    SHOW_LOADER: (state) => {
        state.loader.block = true;
        return state;
    },
    HIDE_LOADER: (state) => {
        state.loader.block = false;
        return state;
    },

    SET_Filter_PAGE: (state, page) => {
        state.filter.page = page;
        return state;
    },
    SET_Filter_RELATIONS: (state, payload) => {
        console.log(payload);
        state.filter.relations = payload;
        return state;
    },
    SET_Filter_SEARCH_IN_COLUMMN: (state, payload) => {
        state.filter.search.searchInColumn = payload;
        return state;
    },

    SET_FILTER_SORT(state, column) {
        if (state.filter.sort.sortColumn == column) {
            state.filter.sort.sortOrder =
                (state.filter.sort.sortOrder.toLowerCase() == 'desc' ? 'ASC' : 'DESC');
        } else {
            state.filter.sort.sortColumn = column;
            state.filter.sort.sortOrder = 'ASC';
        }
        return state;
    },
};

export default mutations;
