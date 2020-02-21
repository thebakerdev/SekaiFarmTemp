<template>
    <div class="user-address__container">
        <transition name="fade" mode="out-in">
        <address-form 
            :countries="countries"
            :user="user"
            :address="address" 
            class="pt-2" 
            v-if="display === 'add' || display === 'edit'"
            @form-event="onComponentEvent">
        </address-form>
        <address-list 
            :addresses="address_list" 
            v-if="display === 'list'"
            @form-event="onComponentEvent">
        </address-list>
        </transition>
    </div>
</template>
<script>
    import AddressList from './AddressList';
    import AddressForm from './AddressForm';

    export default {
        components: {
            'address-list': AddressList,
            'address-form': AddressForm
        },
        props: {
            addresses: {
                type: Array,
                required: true
            },
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
                address: {},
                address_list: [],
                display: 'list' //list, add, edit
            }
        },
        methods: {
            // Listen to child component events
            onComponentEvent(data) {
                
                if (data.type === 'cancel') {
                    this.display = 'list';
                }

                if (data.type === 'edit') {
                    this.display = 'edit';
                    this.address = data.payload.address;
                }

                if (data.type === 'add') {
                    this.display = 'add';
                    this.address = {};
                }

                if (data.type === 'update-list') {
                    this.display = 'list';
                    this.address_list = data.payload.addresses;
                }
            }
        },
        // Set initial data
        created() {
            this.address_list = this.addresses;
        }
    }
</script>