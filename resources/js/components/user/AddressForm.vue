<template>
    <div class="user-address__form">
        <form action="/address/store" method="post" class="ui form" @submit.prevent="onSubmit()" ref="address_form" @keydown="form.errors.clear($event.target.name)">
            <div class="field" :class="form.errors.has('name') ? 'error':''">
                <label for="name">{{ trans('translations.labels.name') }}</label>
                <input type="text" id="name" name="name" v-model="form.name">
            </div>
            <div class="two fields">
                <div class="eight wide field" :class="form.errors.has('country') ? 'error':''">
                    <label for="country">{{ trans('translations.labels.country') }}</label>
                    <div id="country_dropdown" class="ui fluid selection dropdown">
                        <input id="country" type="hidden" name="country" v-model="form.country">
                        <i class="dropdown icon"></i>
                        <div class="default text">{{ trans('translations.labels.country') }}</div>
                        <div class="menu">
                            <div v-for="(country,key) in countries" :key="key" class="item" :data-value="country">{{ country }}</div>
                        </div>
                    </div>
                </div>
                <div class="eight wide field" :class="form.errors.has('state') ? 'error':''">
                    <label for="state">{{ trans('translations.labels.state') }}</label>
                    <input type="text" id="state" class="input" name="state" v-model="form.state">
                </div>
            </div>
            <div class="two fields">
                <div class="eight wide field" :class="form.errors.has('city') ? 'error':''">
                    <label for="city">{{ trans('translations.labels.city') }}</label>
                    <input type="text" id="city" class="input" name="city" v-model="form.city">
                </div>
                <div class="eight wide field" :class="form.errors.has('postal') ? 'error':''">
                    <label for="postal">{{ trans('translations.labels.postal') }}</label>
                    <input type="text" id="postal" class="input" name="postal" v-model="form.postal">
                </div>
            </div>
            <div class="field" :class="form.errors.has('address1') ? 'error':''">
                <label for="address1">{{ trans('translations.labels.address_1') }}</label>
                <input type="text" id="address1" class="input" name="address1" v-model="form.address1">
            </div>
            <div class="field">
                <label for="address2">{{ trans('translations.labels.address_2') }}</label>
                <input type="text" id="address2" class="input" name="address2" v-model="form.address2">
            </div>
            <div class="field" :class="form.errors.has('phone') ? 'error':''">
                <label for="phone">{{ trans('translations.labels.phone') }}</label>
                <div class="two fields">
                    <div class="five wide field">
                        <div id="calling_code_dropdown" class="ui fluid selection dropdown">
                            <input id="calling_code" type="hidden" name="calling_code">
                            <i class="dropdown icon"></i>
                            <div class="default text">{{ trans('translations.labels.code') }}</div>
                            <div class="menu">
                                <div class="item" data-value="+1"><i class="us flag"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="eleven wide field">
                        <imask-input  name="phone" :mask="'+num'" :blocks="{ num: { mask: Number}}" :lazy="true" v-model="form.phone"/>
                    </div>
                </div>
            </div>
            <div class="field text-right ">
                <button class="ui button button--primary">{{ trans('translations.buttons.save_changes') }}</button>
                <button type="button" class="ui button" @click="cancel()">{{ trans('translations.buttons.cancel') }}</button>
            </div>
        </form>
    </div>
</template>
<script>
    import {IMaskComponent} from 'vue-imask';

    import Form from 'form-backend-validation'; 
    
    import FormValidation from './../../mixins/formValidation';

    export default {
        components: {
            'imask-input': IMaskComponent
        },
        props: {
            countries: {
                type: Object,
                required: true
            },
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                form:  new Form({
                    id: '',
                    name: '',
                    country: '',
                    state: '',
                    city: '',
                    postal: '',
                    address1: '',
                    address2: '',
                    phone: ''
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

                this.validate(this.form, this.$refs.address_form).then(response => {

                    this.$emit('form-event',{
                        type: 'saved',
                        payload: {
                            address: response.address
                        }
                    });

                    if (response.status === 'success') {
                        setTimeout(()=>{
                            this.$notify({
                                group: 'user-notification',
                                title: vm.trans('translations.headings.notification'),
                                text: vm.trans('translations.texts.account_updated')
                            });
                        },400);
                    }
                    
                }).finally(() => {
                    this.button.state = 'active';
                });
            }
        },
        mounted() {

            const vm = this;

            $('.ui.dropdown').dropdown();

            this.form.populate({
                'id': this.user.id
            });

            $('#country').change(function(){
                
                vm.form.populate({
                    country: $(this).val()
                });

                vm.form.errors.clear('country');
            });
        },
        mixins: [FormValidation]
    }
</script>