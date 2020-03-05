<template>
    <div>
        <div class="flex justify-between">
            <a href="#" @click="$router.back()" class="text-blue-400">Back</a>
        </div>
        <form @submit.prevent="submitForm">
            <InputField
                name="name"
                label="Contact Name"
                placeholder="Contact Name"
                @update:field="form.name = $event"
                :errors="errors"
                :data="form.name"
            />
            <InputField
                name="email"
                label="e-mail"
                placeholder="E-mail"
                @update:field="form.email = $event"
                :errors="errors"
                :data="form.email"
            />
            <InputField
                name="company"
                label="company"
                placeholder="Company"
                @update:field="form.company = $event"
                :errors="errors"
                :data="form.company"
            />
            <InputField
                name="birthday"
                label="Birthday"
                placeholder="DD/MM/YYY"
                @update:field="form.birthday = $event"
                :errors="errors"
                :data="form.birthday"
            />
            <div class="flex justify-end">
                <button
                    class="px-4 py-2 rounded text-red-500 border mr-5 hover:border-red-700"
                >
                    Cancel
                </button>
                <button
                    class="bg-blue-500 px-4 py-2 rounded text-white hover:bg-blue-400"
                >
                    Save
                </button>
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
