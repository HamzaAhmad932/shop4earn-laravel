let state = {
    customer_dashboard: {
        user: {
            name: ''
        },
        label: [],
        series: []
    },
    admin_dashboard: {
        user: {
            name: ''
        },
        line_graph: {
            label: [],
            series: []
        },
        rank: 'Admin',
        total_network_members: '',
        total_paid_amount: '',
        today_joined: '',
        total_approved_customers: '',
        total_sale: '',
        profit: '',
        donations: '',
        withdrawal_requests: [],
        rank_overview: [],
        top_users: [],
        sharing_consumed: '',
        total_sharing: '',
        sharing_amount_balance: '',
        reward_list: []
    }
};

export default state;
