import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://127.0.0.1:8000', 
  timeout: 1000, // Tiempo de espera en milisegundos
  headers: {
    'Content-Type': 'application/json',
  },
});

export default instance;
