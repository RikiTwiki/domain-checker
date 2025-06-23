import axios from 'axios';
axios.defaults.baseURL = 'http://127.0.0.1:8000';

import { createApp } from 'vue';
import App from './components/App.vue';

createApp(App).mount('#app');
