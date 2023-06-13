import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: `${import.meta.env.API_BASE_URL}/api`,
});

axiosInstance.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = token; // Set Authorization header
    }
    return config;
  });

export default axiosInstance;