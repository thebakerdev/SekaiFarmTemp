<template>
    <div class="user-address__list">
        <table role="table" class="table-custom table-custom--borderless table-custom--spaced">
            <thead role="rowgroup">
                <tr role="row">
                    <th role="columnheader">{{ trans('translations.labels.name') }}</th>
                    <th role="columnheader">{{ trans('translations.labels.address') }}</th>
                    <th role="columnheader">{{ trans('translations.labels.postal') }}</th>
                    <th role="columnheader">{{ trans('translations.labels.phone') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="rowgroup">
                <tr role="row" class="table-custom__row--raised" v-for="(address, key) in addresses" :key="key" :class="{active: address.is_default ==='1'}">
                    <td role="cell" :data-header="trans('translations.labels.name')">{{ address.name }}</td>
                    <td role="cell" :data-header="trans('translations.labels.address')">
                        <address class="w-50">
                            {{ address.address1 }} <br>
                            {{ address.address2 }}<br>
                            {{ address.state }} {{ address.postal }}<br>
                            {{ address.country }}<br>
                            <small class="color--blue" v-if="address.is_default === '1'">{{ trans('translations.texts.default_address') }}</small>
                            <small class="c-pointer" v-else @click="setDefault(address.id)">{{ trans('translations.texts.set_as_default') }}</small>
                        </address>   
                    </td>
                    <td role="cell" :data-header="trans('translations.labels.postal')">{{ address.postal }}</td>
                    <td role="cell" :data-header="trans('translations.labels.phone')">{{ address.phone }}</td>
                    <td><a class="link link--secondary text-uppercase" href="javascript:void(0)" @click="triggerEdit(address)">{{ trans('translations.buttons.edit') }}</a></td>
                </tr>
            </tbody>
        </table>
        <div class="mt-1 text-right">
            <button class="ui button button--primary" @click="triggerAdd()">{{ trans('translations.buttons.add_new_address') }}</button>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            addresses: {
                type: Array,
                required: true
            }
        },
        methods: {
            setDefault(id) {

                const vm = this;

                axios.put('/address/set-default',{
                    id: id
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
                                text: vm.trans('translations.texts.default_address_set'),
                                type: 'success'
                            });
                        },200);
                    }
                });
            },
            triggerAdd() {
                this.$emit('form-event',{
                    type: 'add',
                    payload: {}
                });
            },
            triggerEdit(address) {
                this.$emit('form-event', {
                    type: 'edit',
                    payload: {
                        address: address
                    }
                });
            }
        }
    }
</script>