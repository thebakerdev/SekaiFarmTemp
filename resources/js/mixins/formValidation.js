import axios from 'axios';

const FormValidation = {
    methods: {
        validate(form) {

            return form[this.$refs.form.method](this.$refs.form.action);
        }
    }
}

export default FormValidation;