<template>
  <div>
    <form @submit.prevent="submitForm">
      <InputField
        name="name"
        label="Contact Name"
        placeholder="Contact Name"
        @update:field="form.name=$event"
        :errors="errors"
      />
      <InputField
        name="email"
        label="e-mail"
        placeholder="E-mail"
        @update:field="form.email=$event"
        :errors="errors"
      />
      <InputField
        name="company"
        label="company"
        placeholder="Company"
        @update:field="form.company=$event"
        :errors="errors"
      />
      <InputField
        name="birthday"
        label="Birthday"
        placeholder="DD/MM/YYY"
        @update:field="form.birthday=$event"
        :errors="errors"
      />
      <div class="flex justify-end">
        <button class="px-4 py-2 rounded text-red-500 border mr-5 hover:border-red-700">Cancel</button>
        <button class="bg-blue-500 px-4 py-2 rounded text-white hover:bg-blue-400">Add Contact</button>
      </div>
    </form>
  </div>
</template>

<script>
import InputField from "../components/InputField";
export default {
  name: "ContactsCreate",
  data: function() {
    return {
      form: {
        name: "",
        email: "",
        company: "",
        birthday: ""
      },
      errors: null
    };
  },
  components: {
    InputField
  },
  methods: {
    submitForm: function() {
      axios
        .post("/api/contacts", this.form)
        .then(response => {})
        .catch(errors => {
          this.errors = errors.response.data.errors;
        });
    }
  }
};
</script>