<template>
    <div class="product-update">
        <div v-if="editing">
            <div class="ui mini icon input product-update__input-wrap" :class="{error: has_error}" data-children-count="1">
                <input type="text"  name="update_value" v-model="update_value" :class="{ disabled: saving}">
                <i class="circular check teal link icon" @click="update"></i>
            </div>
            <i class="close icon" @click="hideInput()"></i>
        </div>
        <div v-else>
            {{ display_text }}
            <i class="edit icon" @click="showInput()"></i>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            currentValue: {
                type: String,
                required: true
            },
            updateId: {
                type: String,
                required: true
            },
            updateKey: {
                type: String,
                required: true
            },
            updateUrl: {
                type: String,
                required: true
            }
        },
        data: function() {
            return {
                display_text: '',
                editing: false,
                has_error: false,
                saving: false,
                update_value:'',
            }
        },
        methods: {
            hideInput: function() {
                this.update_value = this.display_text;
                this.editing = false;
                this.has_error = false;
            },
            showInput: function() {
                this.update_value = this.display_text;
                this.editing = true;
            },
            update: function() {
                
                const vm = this;
                if (this.validate()) {
                    this.saving = true;
                   
                   axios.put(this.updateUrl,{
                       csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                       id: this.updateId,
                       key: this.updateKey,
                       value: this.update_value
                   }).then(response => {
                       vm.display_text = vm.update_value;
                       vm.editing = false;
                   }).catch(error => {
                       vm.has_error = true;
                   }).finally(()=> {
                       vm.saving = false;
                   });
                }
            },
            validate: function() {
                this.has_error = false;
                let pattern = new RegExp("^[0-9]*$");
                if (this.update_value && pattern.test(this.update_value)) {
                    return true;
                }
                
                this.has_error = true;
                
                return false;
            }
        },
        mounted: function() {
            this.display_text = this.currentValue;
        }
    }
</script>
<style lang="scss" scoped>
    .product-update {
        white-space: nowrap;
        
        i.edit {
            color: #9B9B9B;
            cursor: pointer;
            visibility: hidden;
            &:hover {
                color: #13CBB5;
            }
        }
        .close {
            color: #E7E7E7;
            cursor: pointer;
            &:hover {
                color: #9B9B9B;
            }
        }
        &:hover i.edit {
            visibility: visible;
        }
    }
    .product-update__input-wrap {
        max-width: 80px;
    }
</style>