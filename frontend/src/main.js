// src/main.js

import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Import the router instance
import { registerPlugins } from '@/plugins'; // Your plugin registration

const app = createApp(App);

registerPlugins(app);

app.use(router); // Use the router instance
app.mount('#app');
