<template>
    <div class="stock-adjust">
        <form method="post" :action="action" ref="form">
            <button type="button" class="mini ui teal button"  @click="showInput()" v-if="!inputVisible">{{ text }}</button>
            <div class="ui mini icon input mr-5 stock-adjust-wrap" data-children-count="1" v-else>
                <input type="text" class="stock-adjust__input" name="stock" v-model="stock">
                <input type="hidden" name="id" :value="productId" />
                <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="_method" value="PUT">
                <i class="circular check teal link icon"  @click="submitForm()"></i>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            csrf: {
                required: true,
                type: String
            },
            action: {
                required: true,
                type: String
            },
            quantity: {
                required: true,
                type: Number
            },
            productId: {
                required: true,
                type: Number
            },
            text: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                inputVisible: false,
                stock: this.quantity
            }
        },
        methods: {

            showInput: function() {
                this.inputVisible = !this.inputVisible;

            },

            submitForm: function() {

                let pattern = new RegExp("^[0-9]*$");

                if(this.stock && pattern.test(this.stock)) {
                    this.$refs.form.submit();
                }
            }
        }
    }
</script>
<style lang="scss" scoped>

    .stock-adjust {
        margin-right: 5px;
    }
    .stock-adjust-wrap {
        max-width: 110px;
    }
</style>
