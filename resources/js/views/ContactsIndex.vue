<template>
<div v-if="loading">Loading...</div>
<div v-else>
    <div v-if="contacts.length == 0">Niste dodali nijedan kontakt.</div>
    <div v-for="contact in contacts">
        <routerLink :to="'/contacts/' + contact.contact_id" class="flex items-center p-4 border-b border-gray-400 hover:bg-gray-100">
            <userCircle :name="contact.name" />
            <div class="pl-4">
                <p class="text-blue-400 font-bold">{{ contact.name }}</p>
                <p class="text-gray-600">{{ contact.phone }}</p>
            </div>
        </routerLink>
    </div>
</div>
</template>

<script>
import userCircle from "../components/userCircle";
export default {
    name: "ContactsIndex",
    components: {
        userCircle
    },
    mounted() {
        axios
            .get("/api/contacts")
            .then(response => {
                this.contacts = response.data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;
                alert("Unable to fetch contacts");
            });
    },
    data: function() {
        return {
            loading: true,
            contacts: null
        };
    }
};
</script>
