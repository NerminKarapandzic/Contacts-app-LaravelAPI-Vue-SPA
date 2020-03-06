<template>
<div class="relative pb-4">
    <label :for="name" class="text-blue-500 uppercase text-xs font-bold absolute pt-2">{{ label }}</label>
    <input type="text" :id="name" class="pt-8 pb-2 w-full border-b focus:outline-none text-gray-800 focus:border-blue-400" :placeholder="placeholder" @input="updateField()" v-model="value" :class="errorClassObject()" />
    <p class="text-red-500 text-sm" v-text="errorMessage()"></p>
</div>
</template>

<script>
export default {
    name: "InputField",
    props: ["name", "label", "placeholder", "errors", "data"],
    data: function() {
        return {
            value: ""
        };
    },
    computed: {
        hasErrors: function() {
            return (
                this.errors &&
                this.errors[this.name] &&
                this.errors[this.name].length > 0
            );
        }
    },
    methods: {
        updateField: function() {
            this.clearErrors();
            this.$emit("update:field", this.value);
        },
        errorMessage: function(field) {
            if (this.hasErrors) {
                return this.errors[this.name][0];
            }
        },
        clearErrors: function() {
            if (this.hasErrors) {
                this.errors[this.name] = null;
            }
        },
        errorClassObject: function() {
            return {
                "error-field": this.hasErrors
            };
        }
    },
    watch: {
        data: function(val) {
            this.value = val;
        }
    }
};
</script>

<style scoped>
.error-field {
    @apply .border-red-500 .border-b-2;
}
</style>
