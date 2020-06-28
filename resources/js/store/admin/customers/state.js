
export const getAddCustomerInitial = ()=>{
    return {
        sponsor_id: '',
        position: 1,
        email: 'a@gmail.com',
        password:'123456',
        password_confirmation: '123456',
        user_id: '',
        name: '',
        city: 'Faisalabad',
        mobile: '03006611403',
        parent_id: '',
        is_manual : false,

        error_status: {
            sponser_id:  false,
            position:  false,
            email: false,
            password: false,
            password_confirmation:  false,
            user_id:  false,
            user_name: '',
            city:  false,
            mobile:  false,
        },
        error_message: {
            sponser_id: '',
            position: '',
            email:'',
            password:'',
            password_confirmation: '',
            user_id: '',
            user_name : '',
            city: '',
            mobile: '',
        },

        positions: [
            {
                label: 'Left',
                code: 1
            },
            {
                label: 'Right',
                code: 2
            }
        ],
        selected_products : [
            {
                product_id : 1,
                qty : '1',
            },
        ],
    }
};

let state = {
    add_customer: getAddCustomerInitial(),
    sponsors: [],
    products: [],
};

export default state;
