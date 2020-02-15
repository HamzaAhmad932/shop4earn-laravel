let mutations = {
    SHOW_LOADER: (state) => {
        state.loader.block = true;
        return state;
    },
    HIDE_LOADER: (state) => {
        state.loader.block = false;
        return state;
    },
};

export default mutations;
