// import './assets/main.css'
import 'bootstrap/dist/css/bootstrap.min.css'; // Importa los estilos de Bootstrap

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from './plugins/axios';

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.config.globalProperties.$axios = axios;
app.mount('#app')
