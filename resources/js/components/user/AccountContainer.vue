<template>
    <div class="user-account__container">
        <transition name="fade" mode="out-in">
            <div class="ui grid" v-if="display === 'list'">
                <div class="sixteen wide mobile eight wide tablet eight wide computer column pb-0 user-dashboard__content-divider">
                    <div class="form-display">
                        <div class="field">
                            <label for="name" class="field__item">{{ trans('translations.labels.name') }}</label>
                            <span id="name" class="field__item">{{ user_info.name }}</span>
                        </div>
                        <div class="field">
                            <label for="email" class="field__item">{{ trans('translations.labels.email') }}</label>
                            <span id="email" class="field__item">{{ user_info.email }}</span>
                        </div>
                        <div class="field">
                            <label for="address" class="field__item">{{ trans('translations.labels.address') }}</label>
                            <div class="field__item">
                                <address id="address">
                                    {{ user_info.address.address1 }} <br>
                                    {{ user_info.address.address2 }}<br>
                                    {{ user_info.address.state }} {{ user_info.address.postal }}<br>
                                    {{ user_info.address.country }}<br>
                                </address>
                                <a class="link link--secondary text-uppercase" :href="addressLink">{{ trans('translations.buttons.edit') }}</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="sixteen wide mobile eight wide tablet eight wide computer column text-center">
                    <button type="button" class="ui button button--primary button--fixed mb-1" @click="display = 'edit'">{{ trans('translations.buttons.edit_profile')  }}</button>
                    <button type="button" class="ui button button--secondary button--fixed" @click="display = 'change-password'">{{ trans('translations.buttons.change_password') }}</button>
                </div>
            </div>
            <account-form :user="user_info" v-if="display === 'edit'" @form-event="onComponentEvent"></account-form>
            <change-password-form :user="user_info" v-if="display === 'change-password'" @form-event="onComponentEvent"></change-password-form>
        </transition>
    </div>
</template>
<script>
    import AccountForm from './AccountForm';

    import ChangePasswordForm from './ChangePasswordForm';

    export default {
        components: {
            'account-form': AccountForm,
            'change-password-form': ChangePasswordForm
        },
        props: {
            user: {
                type: Object,
                required: true
            },
            addressLink: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                display: 'list',
                user_info: {}
            }
        },
        methods: {
            // Listen to child component events
            onComponentEvent(data) {
                if (data.type === 'cancel') {
                    this.display = 'list';
                }

                if (data.type === 'updated') {
                    this.display = 'list';
                    this.user_info = data.payload.user;
                }
            } 
        },
        // Set initial data
        created() {
            this.user_info = this.user;
        }
    }
</script>