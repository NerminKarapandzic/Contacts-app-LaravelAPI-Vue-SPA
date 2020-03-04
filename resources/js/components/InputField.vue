<template>
  <div class="relative pb-4">
    <label :for="name" class="text-blue-500 uppercase text-xs font-bold absolute pt-2">{{label}}</label>
    <input
      type="text"
      :id="name"
      class="pt-8 pb-2 w-full border-b focus:outline-none text-gray-800 focus:border-blue-400"
      :placeholder="placeholder"
      @input="updateField()"
      v-model="value"
    />
  </div>
</template>

<script>
export default {
  name: "InputField",
  props: ["name", "label", "placeholder"],
  data: function() {
    return {
      value: ""
    };
  },
  methods: {
    updateField: function() {
      this.$emit("update:field", this.value);
    }
  }
};
</script>