import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent";
import ContactsCreate from "./views/ContactsCreate";
import Contact from "./views/Contact";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: "/", component: ExampleComponent },
        { path: "/contacts/create", component: ContactsCreate },
        { path: "/contacts/:id", component: Contact }
    ],
    mode: "history"
});
