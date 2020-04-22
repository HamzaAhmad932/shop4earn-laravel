let state = {

    loader: {
        msg: 'Please Wait...',
        block: false,
        html: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
    },

    filter: {
        dateOne: '',
        dateTwo: '',
        recordsPerPage: 10,
        page: 1,
        columns: ["*"],
        relations: [],
        sort: {
            sortOrder: "DESC",
            sortColumn: "id",
        },
        constraints: [],
        search: {
            searchInColumn: [],
            searchStr: ""
        },
    },
};

export default state;
