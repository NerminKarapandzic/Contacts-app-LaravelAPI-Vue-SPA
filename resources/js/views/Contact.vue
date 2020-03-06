<template>
<div v-if="loading">Loading...</div>
<div v-else>
    <div>
        <div class="flex justify-between">
            <a href="#" @click="$router.back()" class="text-blue-400">Nazad</a>
            <div class="relative">
                <router-link :to="'/contacts/' + contact.contact_id + '/edit'" class="px-4 py-2 font-bold text-green-500 rounded text-sm border border-green-500 mr-3 hover:border-green-400 hover:bg-green-500 hover:text-white">Uredi</router-link>

                <a href="#" class="px-4 font-bold py-2 text-red-500 rounded text-red-500 border border-red-500 text-sm hover:bg-red-500 hover:text-white" @click="modal = !modal">Izbriši</a>
                <div v-if="modal" class="absolute rounded-lg bg-blue-400 text-white p-6 z-20 w-64 right-0 mt-4">
                    <p>Da li ste sigurni?</p>

                    <div class="flex items-center justify-end pt-6">
                        <button class="pr-4 text-white" @click="modal = !modal">
                            Odustani
                        </button>
                        <button class="px-4 py-2 bg-red-500 text-white hover:bg-red-400 rounded text-sm font-bold" @click="destroy">
                            Izbriši
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center pt-6">
            <userCircle :name="contact.name" />
            <p class="pl-5 text-xl">{{ contact.name }}</p>
        </div>

        <p class="pt-6 text-gray-600 font-bold uppercase font-sm">
            Broj telefona
        </p>
        <p class="pt-2 text-blue-400">{{ contact.phone }}</p>
        <p class="pt-6 text-gray-600 font-bold uppercase font-sm">
            Grad
        </p>
        <p class="pt-2 text-blue-400">{{ contact.city }}</p>
        <p class="pt-6 text-gray-600 font-bold uppercase font-sm">
            Adresa
        </p>
        <p class="pt-2 text-blue-400">{{ contact.adress }}</p>
    </div>
</div>
</template>

<script>
import userCircle from "../components/userCircle";
export default {
    name: "Contact",
    components: {
        userCircle
    },
    mounted() {
        axios
            .get("/api/contacts/" + this.$route.params.id)
            .then(response => {
                this.contact = response.data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;
            });
    },
    data: function() {
        return {
            contact: null,
            loading: true,
            modal: false
        };
    },
    methods: {
        destroy: function() {
            axios
                .delete("/api/contacts/" + this.$route.params.id)
                .then(response => {
                    this.$router.push("/contacts");
                })
                .catch(error => {
                    alert("Internal error, unable to delete a contact.");
                });
        }
    }
};
</script>
