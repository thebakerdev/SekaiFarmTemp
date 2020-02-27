const Common = {
    methods: {
        // initialize dropdown to work with form-validation
        initializeDropdown(form, field_name) {

            $('.ui.dropdown').dropdown();

            $('#'+field_name).change(function(){
                
                let fields = {};

                fields[field_name] = $(this).val();

                form.populate(fields);

                form.errors.clear(field_name);
            });
        }
    }
}

export default Common;