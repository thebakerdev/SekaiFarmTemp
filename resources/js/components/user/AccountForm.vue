<template>
    <div class="user-account__form">
        <form 
            action="/account/update" 
            method="get" 
            class="ui form" 
            data-method="put" 
            ref="account_update_form" 
            @submit.prevent="onSubmit()" 
            @keydown="form.errors.clear($event.target.name)">
            <div class="field" :class="form.errors.has('name') ? 'error':''">
                <label for="name">{{ trans('translations.labels.name') }}</label>
                <input type="text" id="name" name="name" v-model="form.name">
            </div>
            <div class="field" :class="form.errors.has('email') ? 'error':''">
                <label for="name">{{ trans('translations.labels.email') }}</label>
                <input type="email" id="email" name="email" v-model="form.email">
            </div>
            <div class="field text-right">
                <button class="ui button button--primary mb-1" :class="buttonStyle">{{ trans('translations.buttons.save_changes') }}</button>
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
                form: new Form({
                    name: '',
                    email: '',
                    address:''
                },{ resetOnSuccess: false})
            }
        },
        methods: {
            // Emit cancel event
            cancel() {
                this.$emit('form-event',{
                    type: 'cancel',
                    payload: {}
                });
            },
            // handles form submission
            onSubmit() {

                const vm = this;

                if (this.button.state === 'active') {

                    this.button.state = 'loading';
                    
                    this.validate(this.form, this.$refs.account_update_form).then(response => {
                    
                        if (response.status === 'success') {

                            this.$emit('form-event',{
                                type: 'updated',
                                payload: {
                                    user: vm.form
                                }
                            });

                            setTimeout(()=>{
                                this.$notify({
                                    group: 'user-notification',
                                    title: vm.trans('translations.headings.notification'),
                                    text: vm.trans('translations.texts.account_updated')
                                });
                            },400);

                        }
                    }).catch(error => {
                        this.button.state = 'active';
                    });
                }
                
                
            },
        },
        created() {
            this.form.populate({
                name: this.user.name,
                email: this.user.email,
                address: this.user.address
            });
        },
        mixins: [FormValidation]
    }
</script>