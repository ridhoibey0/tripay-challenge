/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap.js";
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

import ExampleComponent from "./components/ExampleComponent.vue";
import App from "./components/App.vue";
import Product from "./components/Product.vue";
import ProductList from "./components/ProductList.vue";
import ProductForm from "./components/ProductForm.vue";
import PaymentList from "./components/payment/PaymentList.vue";
import InvoiceList from "./components/invoice/InvoiceList.vue";
import Invoice from "./components/invoice/Invoice.vue";
const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/", component: ProductList },
        { path: "/products/create", component: ProductForm },
        { path: "/products/:id", component: Product },
        { path: "/products/:id/edit", component: ProductForm },
        { path: "/checkout/:id/payment", component: PaymentList },
        { path: "/invoices", component: InvoiceList },
        { path: "/invoices/:id", component: Invoice },
    ],
});
const app = createApp(App);

app.use(router);
app.component("example-component", ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount("#app");
