<template>
    <div class="user-address__form">
        <form 
            :action="action" 
            method="post"
            :data-method="method"  
            class="ui form" 
            @submit.prevent="onSubmit()" 
            ref="address_form" 
            @keydown="form.errors.clear($event.target.name)">
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
                    <div class="eight wide field">
                        <imask-input  name="phone" :mask="'+num'" :blocks="{ num: { mask: Number}}" :lazy="true" v-model="form.phone"/>
                    </div>
                </div>
            </div>
            <div class="field text-right ">
                <button class="ui button button--primary mb-1" :class="buttonStyle">{{ trans('translations.buttons.save_changes') }}</button>
                <button type="button" class="ui button button--danger mb-1" v-if="show_delete === true && address.is_default !=='1'" @click="deleteAddress(address.id)">{{ trans('translations.buttons.delete') }}</button>
                <button type="button" class="ui button mb1" @click="cancel()">{{ trans('translations.buttons.cancel') }}</button>
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
            },
            address: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                action: '',
                method: '',
                form:  new Form({
                    id: '',
                    user_id: '',
                    name: '',
                    country: '',
                    state: '',
                    city: '',
                    postal: '',
                    address1: '',
                    address2: '',
                    phone: ''
                }),
                show_delete: false
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
            // Deletes selected address
            deleteAddress(id) {

                const vm = this;

                axios.delete('/address/delete',{
                    data: {
                        id:id
                    }
                }).then(response => {

                    if (response.data.status === 'success') {

                        this.$emit('form-event',{
                            type: 'update-list',
                            payload: {
                                addresses: response.data.addresses
                            }
                        });

                        setTimeout(()=>{
                            this.$notify({
                                group: 'user-notification',
                                title: vm.trans('translations.headings.notification'),
                                text: vm.trans('translations.texts.address_deleted'),
                                type: 'error'
                            });
                        },400);
                    }
                }).catch(error => {
                    alert('Unauthorized action.')
                });
            },
            // Initialize semantic dropddown button
            initializeDropdown() {

                const vm = this;

                $('.ui.dropdown').dropdown();

                $('#country').change(function(){
                
                    vm.form.populate({
                        country: $(this).val()
                    });

                    vm.form.errors.clear('country');
                });
            },
            // Innitialize form action, method, post to handle add or update
            initializeForm() {

                const add_url = '/address/store';

                const update_url = '/address/update';

                // Check if address object is not empty
                if (Object.entries(this.address).length > 0) {

                    this.action = update_url;

                    this.method = 'put';

                    this.form.populate({
                        id: this.address.id,
                        user_id: this.user.id,
                        name: this.address.name,
                        country: this.address.country,
                        state: this.address.state,
                        city: this.address.city,
                        postal: this.address.postal,
                        address1: this.address.address1,
                        address2: this.address.address2,
                        phone: this.address.phone
                    });

                    this.show_delete = true;

                } else {

                    this.action = add_url;

                    this.method = 'post';

                    this.form.populate({
                        user_id: this.user.id,
                    });

                    this.show_delete = false;
                }
            },
            // Handles form submission
            onSubmit() {

                const vm = this;

                if (this.button.state === 'active') {

                    this.button.state = 'loading';

                    this.validate(this.form, this.$refs.address_form).then(response => {

                        if (response.status === 'success') {

                            let message = (response.action === 'store') ? vm.trans('translations.texts.new_address_added') : vm.trans('translations.texts.address_updated');

                            this.$emit('form-event',{
                                type: 'update-list',
                                payload: {
                                    addresses: response.addresses
                                }
                            });

                            setTimeout(()=>{
                                this.$notify({
                                    group: 'user-notification',
                                    title: vm.trans('translations.headings.notification'),
                                    text: message
                                });
                            },400);
                        }
                        
                    }).finally(() => {
                        this.button.state = 'active';
                    });
                }
            }
        },
        created() {
            this.initializeForm();
        },
        mounted() {

            setTimeout(()=>{
                this.initializeDropdown();
            },200);
            
        },
        mixins: [FormValidation]
    }
</script>