<template>
    <div class="user-auth">
        <transition name="fade" mode="out-in">
            <div class="login" v-if="show_login" key="login">
                <h5 class="ui user-auth__title">{{ trans('translations.texts.sign_in') }}</h5>
                <form method="post" :action="loginAction" ref="login_form" class="ui form login__form" @submit.prevent="onLogin" @keydown="login_data.errors.clear($event.target.getAttribute('data-name'))">
                    <div class="field" :class="login_data.errors.has('email') ? 'error':''">
                        <label for="login_email">{{ trans('translations.labels.email') }}</label>
                        <input type="email" id="login_email" name="login_email" data-name="email" v-model="login_data.email">
                    </div>
                    <div class="field" :class="login_data.errors.has('password') ? 'error':''">
                        <label for="login_password">{{ trans('translations.labels.password') }}</label>
                        <input type="password" id="login_password" name="login_password" data-name="password" v-model="login_data.password">
                    </div>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="color--yellow" @click="show_login = false">{{ trans('translations.texts.forgot_password') }}</a>
                    </div>
                    <div class="mt-2 text-center user-auth__actions">
                        <button type="submit" class="ui button button--primary mr-1" :class="{loading: is_loading, disabled: is_loading}">{{ trans('translations.texts.sign_in') }}</button>
                        <button type="button" class="ui  cancel button mr-0" :class="{disabled: is_loading}" @click="closeModal()">{{ trans('translations.buttons.cancel') }}</button>
                    </div>
                </form>
            </div>
            <div class="password-reset" v-if="!show_login" key="reset">
                <h5 class="ui user-auth__title">{{ trans('translations.texts.reset_password') }}</h5>
                <form method="post" :action="forgotPasswordAction" ref="reset_form" class="ui form" @submit.prevent="onReset" @keydown="reset_data.errors.clear($event.target.getAttribute('data-name'))">
                    <div class="user-auth__message user-auth__message--success mb-1" v-if="show_reset_message"><span>{{ reset_message }}</span> <i class="icon close" @click="show_reset_message = false"></i></div>
                    <div class="field" :class="reset_data.errors.has('email') ? 'error':''">
                        <label for="reset_email">{{ trans('translations.labels.email') }}</label>
                        <input type="email" id="reset_email" name="login_email" data-name="email" v-model="reset_data.email">
                    </div>
                    <div class="mt-2 text-center login__actions">
                        <button type="submit" class="ui button button--primary mr" :class="{loading: is_loading, disabled: is_loading}">{{ trans('translations.buttons.send_reset_link') }}</button>
                    </div>
                    <div class="text-center mt-1">
                        <a href="javascript:void(0)" class="color--yellow" @click="show_login = true">{{ trans('translations.buttons.back_to_login') }}</a>
                    </div>
                </form>
            </div>
        </transition>
    </div>
</template>
<script>

    import Form from 'form-backend-validation'; 

    import FormValidation from './../../mixins/formValidation';

    export default {
        props:{
            loginAction: {
                type: String,
                required: true
            },
            forgotPasswordAction: {
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
                is_loading: false,
                show_login: true,
                show_reset_message: false,
                login_data: new Form({
                    email: '',
                    password: ''
                },{ resetOnSuccess: false }),
                reset_data: new Form({
                    email: ''
                }),
                reset_message: ''
            }
        },
        methods: {
            closeModal() {
                $('#login_modal').modal('hide');
            },
            onLogin() {

                const vm = this;

                vm.is_loading = true;

                this.validate(this.login_data, this.$refs.login_form).then(response => {
                    if (response.status === 'success') {
                        location.href = response.redirect_path;
                    }
                }).catch(error => {
                    vm.is_loading = false;
                });
            },
            onReset() {

                const vm = this;

                vm.is_loading = true;

                this.validate(this.reset_data, this.$refs.reset_form).then(response => {

                    if (response.status === 'success') {
                       vm.show_reset_message = true;
                       vm.reset_message = response.message;
                    }
                }).catch(error => {

                    let data = error.response.data;
                    
                    if (error.response.status === 500) {
                        vm.reset_message = data.message;
                        vm.show_reset_message = true;
                    }
        
                }).finally(()=> {
                    vm.is_loading = false;
                });
            }
        },
        mixins: [FormValidation]
    }
</script>