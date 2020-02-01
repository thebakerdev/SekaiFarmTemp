const FormValidation = {
    methods: {
        validate(form_data, form) {

            return form_data[form.method](form.action);
        }
    }
}

export default FormValidation;