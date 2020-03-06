<template>
<div>
    <form @submit.prevent="submitForm">
        <InputField name="name" label="Ime i prezime" placeholder="Ime i prezime" @update:field="form.name = $event" :errors="errors" />
        <InputField name="city" label="Grad" placeholder="Grad" @update:field="form.city = $event" :errors="errors" />
        <InputField name="adress" label="Adresa" placeholder="Adresa" @update:field="form.adress = $event" :errors="errors" />
        <InputField name="phone" label="Broj telefona" placeholder="062/ 062 / 062" @update:field="form.phone = $event" :errors="errors" />
        <div class="flex justify-end">
            <button class="px-4 py-2 rounded text-red-500 border mr-5 hover:border-red-700">
                Odustani
            </button>
            <button class="bg-blue-500 px-4 py-2 rounded text-white hover:bg-blue-400">
                Dodaj kontakt
            </button>
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
                city: "",
                adress: "",
                phone: ""
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
                .then(response => {
                    this.$router.push(response.data.data.links.self);
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors;
                });
        }
    }
};
</script>
