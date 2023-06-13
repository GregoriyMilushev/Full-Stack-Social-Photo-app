import { defineStore } from 'pinia'

import { api } from '../../api/apiFactory'

const RESOURCE_NAME = 'auth';

export const useAuthStore = defineStore(RESOURCE_NAME, {
  state: () => ({
    auth: undefined,
    loading: false
  }),
  actions: {
    async login(username, password) {
      this.loading = true;
      try {
        console.log(RESOURCE_NAME);
        const response = await api(RESOURCE_NAME).login({ username, password });
        console.log('22222');
        const { access_token, token_type } = response.data;
        const token = `${token_type} ${access_token}`;
        localStorage.setItem('token', token);
        
        await this.me();
      } finally {
        this.loading = false;
      }
    },

    async registrate(username, password) {
      this.loading = true;
      try {
        const response = await api(RESOURCE_NAME).register({ username, password });
        const { access_token, token_type } = response.data;
        const token = `${token_type} ${access_token}`;
        localStorage.setItem('token', token);
        
        await this.me();
      } finally {
        this.loading = false;
      }
    },

    async logout() {
      await api(RESOURCE_NAME).logout();
      localStorage.removeItem('token');
      this.auth = undefined;
    },

    async me() {
      const { data } = await api(RESOURCE_NAME).me();
      this.auth = data;
    }
  }
})
