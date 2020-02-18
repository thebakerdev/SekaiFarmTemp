const FormValidation = {
    computed: {
        buttonStyle() {
            return {
                'disabled': this.button.state === 'disabled',
                'loading': this.button.state === 'loading'
            }
        }
    },
    data() {
        return {
            button: {
                state: 'active' // active, loading, disabled
            }
        }
    },
    methods: {
        /* Check if the field is updated */
        checkIfUpdated(previous,current) {

            if (previous.trim() === current.trim()) {

                return false;
            }

            return true;
        },
        /* Sends and validate the form using form-backend-validation plugin */
        validate(form_data, form) {

            let method = form.method;

            //check if data attribute is set. This is for put and delete request
            if (typeof form.dataset.method !== 'undefined') {
                method = form.dataset.method;
            }

            console.log(method);

            return form_data[method](form.action);
        }
    }
}

export default FormValidation;