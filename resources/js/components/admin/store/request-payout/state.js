let state = {

    payout_list :{
        data:[],
    },
    payment_methods: [],
    available_amount: [
    {
        label: 1000,
        code: 1000
    },
    {
        label: 2000,
        code: 2000
    },
    {
        label: 3000,
        code: 3000
    },
    {
        label: 5000,
        code: 5000
    }
],
    add_payout: {
        pm_id: '',
        amount: 0,
        phone: '',
        password: '',

        error_status:{
            pm_id: false,
            amount: false,
            phone: false,
            password: false,
        },
        error_message:{
            pm_id: '',
            amount: '',
            phone: '',
            password: '',
        }
    },
};


export default state;
