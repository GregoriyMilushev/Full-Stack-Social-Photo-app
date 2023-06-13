import axios from 'axios';

const $axios = axios.create({
  baseURL: `${import.meta.env.API_BASE_URL}/api`,
});

export default $axios;
