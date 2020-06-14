let states = {
    register: {
        sponsor_id: '',
        position: 1,
        user_id: '',
        email: '',
        phone: '',
        name: '',
        city: '',
        password: '',
        password_confirmation: '',
        general_status: false,
        general_error: '',

        error_message: {
            sponsor_id: '',
            user_id: '',
            email: '',
            phone: '',
            name: '',
            city: '',
            password: '',
            password_confirmation: '',
        },

        error_status: {
            sponsor_id: false,
            user_id: false,
            email: false,
            phone: false,
            name: false,
            city: false,
            password: false,
            password_confirmation: false,
        }
    }
};


export default states;
