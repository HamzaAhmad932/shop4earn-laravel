let state = {
    dashboard_data: {
        user: {
            name: ''
        }
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
    }
};

export default state;
