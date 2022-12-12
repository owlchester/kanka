import { createApp } from 'vue'
const app = createApp({})

app.component('billing-management', require('./components/subscription/BillingManagement.vue').default)
app.mount('#billing');
