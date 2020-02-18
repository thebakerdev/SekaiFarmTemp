<template>
    <div class="user-account__form">
        <form 
            action="/account/change-password" 
            method="get" 
            class="ui form" 
            data-method="put" 
            ref="password_update_form"
            @submit.prevent="onSubmit()" >
            <div class="field" :class="form.errors.has('password') ? 'error':''">
                <label for="password">{{ trans('translations.labels.password') }}</label>
                <input type="password" id="password" name="password" v-model="form.password">
            </div>
            <div class="field" :class="form.errors.has('password_confirmation') ? 'error':''">
                <label for="password">{{ trans('translations.labels.confirm_password') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation">
            </div>
            <div class="field text-right">
                <button class="ui button button--primary mb-1" :class="buttonStyle">{{ trans('translations.buttons.change_password') }}</button>
                <button type="button" class="ui button mb-1" @click="cancel()">{{ trans('translations.buttons.cancel') }}</button>
            </div>
        </form>
    </div>
</template>
<script>
    import Form from 'form-backend-validation'; 
    
    import FormValidation from './../../mixins/formValidation';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                modified: false,
                form: new Form({
                    password: '',
                    password_confirmation: '',
                })
            }
        },
        methods: {
            cancel() {
                this.$emit('form-event',{
                    type: 'cancel',
                    payload: {}
                });
            },
            onSubmit() {

                const vm = this;

                this.button.state = 'loading';

                this.validate(this.form, this.$refs.password_update_form).then(response => {
                    
                    if (response.status === 'success') {

                        this.$emit('form-event',{
                            type: 'updated',
                            payload: {
                                user: vm.user
                            }
                        });

                        setTimeout(() => {
                            this.$notify({
                                group: 'user-notification',
                                title: vm.trans('translations.headings.notification'),
                                text: vm.trans('translations.texts.password_updated'),
                            });
                        },400);
                    }
                }).finally(() => {
                    this.button.state = 'active';
                });
            },
        },
        mixins: [FormValidation]
    }
</script>