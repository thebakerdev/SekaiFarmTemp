<template>
    <div class="user-auth">
        <div class="login">
            <h5 class="ui small header login__title">{{ trans('translations.texts.sign_in') }}</h5>
            <form method="post" :action="action" ref="form" class="ui form login__form" @submit.prevent="onSubmit">
                <div class="field" :class="form.errors.has('email') ? 'error':''">
                    <label for="login_email">{{ trans('translations.labels.email') }}</label>
                    <input type="email" id="login_email" name="login_email" v-model="form.email">
                </div>
                <div class="field" :class="form.errors.has('password') ? 'error':''">
                    <label for="login_password">{{ trans('translations.labels.password') }}</label>
                    <input type="password" id="login_password" name="login_password" v-model="form.password">
                </div>
                <div class="text-center">
                    <a href="" class="color--yellow">{{ trans('translations.texts.forgot_password') }}</a>
                </div>
                <div class="mt-2 text-center login__actions">
                    <button type="submit" class="ui button button--primary" :class="{disabled: isLoading}">{{ trans('translations.texts.sign_in') }}</button>
                    <button type="button" class="ui  cancel button" :class="{disabled: isLoading}">{{ trans('translations.buttons.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>

    import Form from 'form-backend-validation'; 

    import FormValidation from './../../mixins/formValidation';

    export default {
        props:{
            action: {
                type: String,
                required: true
            },
            redirectTo: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                isLoading: false,
                form: new Form({
                    email: '',
                    password: ''
                })
            }
        },
        methods: {
            onSubmit() {

                const vm = this;

                vm.isLoading = true;

                this.validate(this.form).then(response => {
                    if (response.status === 'success') {
                        location.href = response.redirect_path;
                    }
                }).catch(error => {
                    //error here
                }).finally(()=> {
                    vm.isLoading = false;
                });
            }
        },
        mixins: [FormValidation]
    }
</script>