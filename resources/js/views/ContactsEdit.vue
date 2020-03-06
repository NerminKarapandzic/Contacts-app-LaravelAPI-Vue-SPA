<template>
<div>
    <div class="flex justify-between">
        <a href="#" @click="$router.back()" class="text-blue-400">Back</a>
    </div>
    <form @submit.prevent="submitForm">
        <InputField name="name" label="Ime i prezime" placeholder="Contact Name" @update:field="form.name = $event" :errors="errors" :data="form.name" />
        <InputField name="city" label="Grad" placeholder="City" @update:field="form.city = $event" :errors="errors" :data="form.city" />
        <InputField name="adress" label="Adresa" placeholder="Adress" @update:field="form.adress = $event" :errors="errors" :data="form.adress" />
        <InputField name="phone" label="Broj telefona" placeholder="062/ 062/ 062" @update:field="form.phone = $event" :errors="errors" :data="form.phone" />
        <div class="flex justify-end">
            <button class="px-4 py-2 rounded text-red-500 border mr-5 hover:border-red-700">Odustani</button>
            <button class="bg-blue-500 px-4 py-2 rounded text-white hover:bg-blue-400">Sačuvaj</button>
        </div>
    </form>
</div>
</template>

<script>
import InputField from "../components/InputField";
export default {
    name: "ContactsEdit",
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
    mounted() {
        axios
            .get("/api/contacts/" + this.$route.params.id)
            .then(response => {
                this.form = response.data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;
            });
    },
    methods: {
        submitForm: function() {
            axios
                .patch("/api/contacts/" + this.$route.params.id, this.form)
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
