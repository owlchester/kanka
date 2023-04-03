import { createApp } from 'vue'
const app = createApp({})
import BillingManagement from "./components/subscription/BillingManagement.vue";

app.component('billing-management', BillingManagement)
app.mount('#billing');
